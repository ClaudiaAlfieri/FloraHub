<?php

use App\Jobs\GenerateUsersReport;
use App\Models\User;
use App\Notifications\UserMessage;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts::admin')] #[Title('Users')] class extends Component {
    use WithPagination;

    public string $search = '';

    public string $role = 'all';

    #[Url(as: 'user', except: '')]
    public string $showing = '';

    #[Locked]
    public ?int $messageUserId = null;

    public string $subject = '';

    public string $body = '';

    /**
     * Open the drawer of the user given in the URL (?user=id).
     */
    public function mount(): void
    {
        if ($this->showing === '') {
            return;
        }

        if ($this->shownUser === null) {
            $this->showing = '';

            return;
        }

        $this->authorize('view', $this->shownUser);

        Flux::modal('user-show')->show();
    }

    /**
     * The users filtered by role and by the search term.
     *
     * @return LengthAwarePaginator<int, User>
     */
    #[Computed]
    public function users(): LengthAwarePaginator
    {
        return User::query()
            ->with('roles')
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->when($this->role !== 'all', fn ($query) => $query->role($this->role))
            ->orderBy('name')
            ->paginate(15);
    }

    /**
     * The user shown in the show drawer.
     */
    #[Computed]
    public function shownUser(): ?User
    {
        return ctype_digit($this->showing)
            ? User::with('roles')->find((int) $this->showing)
            : null;
    }

    /**
     * Go back to the first page whenever the search term changes.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Go back to the first page whenever the role filter changes.
     */
    public function updatedRole(): void
    {
        $this->resetPage();
    }

    /**
     * Open the show drawer with the user's details.
     */
    public function show(int $id): void
    {
        $user = User::findOrFail($id);

        $this->authorize('view', $user);

        $this->showing = (string) $user->id;

        Flux::modal('user-show')->show();
    }

    /**
     * Close the show drawer and remove the user from the URL.
     */
    public function closeShow(): void
    {
        $this->showing = '';

        Flux::modal('user-show')->close();
    }

    /**
     * Open the modal to send a message to the user.
     */
    public function openMessage(int $id): void
    {
        $user = User::findOrFail($id);

        $this->authorize('notify', $user);

        $this->resetValidation();
        $this->messageUserId = $user->id;
        $this->subject = '';
        $this->body = '';

        Flux::modal('user-message')->show();
    }

    /**
     * Queue the message: it is delivered in the application and by email by a queue worker.
     */
    public function sendMessage(): void
    {
        $validated = $this->validate([
            'subject' => ['required', 'string', 'max:120'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $user = User::findOrFail($this->messageUserId);

        $this->authorize('notify', $user);

        $user->notify(new UserMessage($validated['subject'], $validated['body']));

        Log::channel('audit')->info('User message queued', ['recipient_id' => $user->id]);

        Flux::modal('user-message')->close();

        Flux::toast(variant: 'success', text: __('Message queued.'));
    }

    /**
     * Ask for the users report: a queued job generates the PDF and notifies the administrator when it is ready.
     */
    public function export(): void
    {
        $this->authorize('export', User::class);

        GenerateUsersReport::dispatch(auth()->user());

        Log::channel('audit')->info('Users report requested');

        Flux::toast(text: __('The report is being generated. You will be notified when it is ready.'));
    }
};
?>

<div>
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-stone-900">{{ __('Users') }}</h2>
            <p class="mt-1 text-sm text-stone-500">{{ __('Registered users of the application.') }}</p>
        </div>

        @can('export', App\Models\User::class)
            <flux:button icon="document-arrow-down" wire:click="export">{{ __('Export PDF') }}</flux:button>
        @endcan
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl border border-stone-200 bg-white">
        <div class="flex flex-wrap items-center gap-3 border-b border-stone-200 p-4">
            <flux:input
                wire:model.live.debounce.300ms="search"
                icon="magnifying-glass"
                placeholder="{{ __('Search by name or email…') }}"
                class="max-w-sm"
            />

            <flux:select wire:model.live="role" class="max-w-44">
                <flux:select.option value="all">{{ __('All roles') }}</flux:select.option>
                <flux:select.option value="admin">{{ __('Administrator') }}</flux:select.option>
                <flux:select.option value="user">{{ __('User') }}</flux:select.option>
            </flux:select>
        </div>

        <div class="px-4 [--flux-bleed:1rem]">
            <flux:table bleed :paginate="$this->users">
                <flux:table.columns>
                    <flux:table.column>{{ __('Name') }}</flux:table.column>
                    <flux:table.column>{{ __('Email') }}</flux:table.column>
                    <flux:table.column>{{ __('Role') }}</flux:table.column>
                    <flux:table.column>{{ __('Verified') }}</flux:table.column>
                    <flux:table.column>{{ __('2FA') }}</flux:table.column>
                    <flux:table.column>{{ __('Registered on') }}</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($this->users as $user)
                        <flux:table.row :key="$user->id">
                            <flux:table.cell>
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 flex-none items-center justify-center rounded-full bg-brand-100 text-sm font-semibold text-brand-700">{{ $user->initials() }}</span>
                                    <button type="button" wire:click="show({{ $user->id }})" class="text-left font-medium text-stone-900 hover:underline">{{ $user->name }}</button>
                                </div>
                            </flux:table.cell>

                            <flux:table.cell>{{ $user->email }}</flux:table.cell>

                            <flux:table.cell>
                                @if ($user->hasRole('admin'))
                                    <flux:badge size="sm" color="amber">{{ __('Administrator') }}</flux:badge>
                                @else
                                    <flux:badge size="sm" class="bg-brand-100! text-brand-700!">{{ __('User') }}</flux:badge>
                                @endif
                            </flux:table.cell>

                            <flux:table.cell>
                                @if ($user->email_verified_at !== null)
                                    <flux:badge size="sm" color="green">{{ __('Yes') }}</flux:badge>
                                @else
                                    <flux:badge size="sm" color="zinc">{{ __('No') }}</flux:badge>
                                @endif
                            </flux:table.cell>

                            <flux:table.cell>
                                @if ($user->two_factor_confirmed_at !== null)
                                    <flux:badge size="sm" color="green">{{ __('Yes') }}</flux:badge>
                                @else
                                    <flux:badge size="sm" color="zinc">{{ __('No') }}</flux:badge>
                                @endif
                            </flux:table.cell>

                            <flux:table.cell>{{ $user->created_at?->format('d/m/Y') }}</flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="6" class="py-10 text-center text-stone-500">
                                {{ __('No users found.') }}
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </div>
    </div>

    <flux:modal name="user-show" flyout class="md:w-lg" @close="closeShow">
        @if ($shownUser = $this->shownUser)
            <div class="space-y-6">
                <div class="flex items-center gap-4">
                    <span class="flex h-14 w-14 flex-none items-center justify-center rounded-full bg-brand-100 text-lg font-semibold text-brand-700">{{ $shownUser->initials() }}</span>
                    <div>
                        <flux:heading size="xl">{{ $shownUser->name }}</flux:heading>
                        <flux:text class="mt-1">{{ $shownUser->email }}</flux:text>
                    </div>
                </div>

                <dl class="grid grid-cols-2 gap-4 rounded-xl bg-stone-50 p-4 text-sm">
                    <div>
                        <dt class="text-stone-500">{{ __('Role') }}</dt>
                        <dd class="mt-1">
                            @if ($shownUser->hasRole('admin'))
                                <flux:badge size="sm" color="amber">{{ __('Administrator') }}</flux:badge>
                            @else
                                <flux:badge size="sm" class="bg-brand-100! text-brand-700!">{{ __('User') }}</flux:badge>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-stone-500">{{ __('Two-factor authentication') }}</dt>
                        <dd class="font-medium text-stone-900">{{ $shownUser->two_factor_confirmed_at !== null ? __('Enabled') : __('Disabled') }}</dd>
                    </div>
                    <div class="col-span-2">
                        <dt class="text-stone-500">{{ __('Email verified at') }}</dt>
                        <dd class="font-medium text-stone-900">{{ $shownUser->email_verified_at?->format('d/m/Y H:i') ?? __('Not verified') }}</dd>
                    </div>
                    <div>
                        <dt class="text-stone-500">{{ __('Created at') }}</dt>
                        <dd class="font-medium text-stone-900">{{ $shownUser->created_at?->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-stone-500">{{ __('Updated at') }}</dt>
                        <dd class="font-medium text-stone-900">{{ $shownUser->updated_at?->format('d/m/Y H:i') }}</dd>
                    </div>
                </dl>

                <div class="flex flex-wrap justify-end gap-2">
                    @can('notify', $shownUser)
                        <flux:button icon="envelope" wire:click="openMessage({{ $shownUser->id }})">{{ __('Send message') }}</flux:button>
                    @endcan

                    <flux:button variant="ghost" wire:click="closeShow">{{ __('Close') }}</flux:button>
                </div>
            </div>
        @endif
    </flux:modal>

    <flux:modal name="user-message" class="md:w-lg">
        <form wire:submit="sendMessage" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Send message') }}</flux:heading>
                <flux:text class="mt-2">{{ __('The user receives the message in the application and by email.') }}</flux:text>
            </div>

            <flux:input wire:model="subject" label="{{ __('Subject *') }}" />

            <flux:textarea wire:model="body" label="{{ __('Message *') }}" rows="6" />

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary" icon="paper-airplane">{{ __('Send') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
