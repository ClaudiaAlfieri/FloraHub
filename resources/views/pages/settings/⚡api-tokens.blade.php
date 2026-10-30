<?php

use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('API tokens')] class extends Component {
    public string $token_name = '';

    /**
     * The new token in plain text. It is shown only once: the database keeps a hash of it.
     */
    #[Locked]
    public ?string $plainTextToken = null;

    /**
     * Only users with the "user" role have API tokens.
     */
    public function mount(): void
    {
        $this->authorize('manage-api-tokens');
    }

    /**
     * The user's tokens, the most recent first.
     *
     * @return Collection<int, PersonalAccessToken>
     */
    #[Computed]
    public function tokens(): Collection
    {
        return auth()->user()->tokens()->latest()->get();
    }

    /**
     * Create a token that can only read the user's account (ability account:read).
     */
    public function createToken(): void
    {
        $this->authorize('manage-api-tokens');

        $validated = $this->validate([
            'token_name' => ['required', 'string', 'max:50'],
        ]);

        $token = auth()->user()->createToken($validated['token_name'], ['account:read']);

        Log::channel('audit')->info('API token created', ['token_id' => $token->accessToken->getKey()]);

        $this->plainTextToken = $token->plainTextToken;
        $this->reset('token_name');

        Flux::toast(variant: 'success', text: __('Token created.'));
    }

    /**
     * Ask for confirmation before revoking one of the user's tokens.
     */
    public function confirmRevoke(int $id): void
    {
        $this->authorize('manage-api-tokens');

        $token = auth()->user()->tokens()->findOrFail($id);

        $this->dispatch('confirm-action',
            heading: __('Revoke token'),
            message: __('Applications that use the token «:name» will stop working. This action cannot be undone.', ['name' => $token->name]),
            confirmEvent: 'api-token-revoke-confirmed',
            params: ['id' => $token->getKey()],
            confirmLabel: __('Revoke'),
        );
    }

    /**
     * Revoke (delete) one of the user's tokens. It is searched through the relationship, so a user can only revoke their own.
     */
    #[On('api-token-revoke-confirmed')]
    public function revoke(int $id): void
    {
        $this->authorize('manage-api-tokens');

        $token = auth()->user()->tokens()->findOrFail($id);

        $token->delete();

        Log::channel('audit')->info('API token revoked', ['token_id' => $token->getKey()]);

        $this->plainTextToken = null;

        Flux::toast(variant: 'warning', text: __('Token revoked.'));
    }
};
?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading level="2" class="sr-only">{{ __('API tokens') }}</flux:heading>

    <x-pages::settings.layout :heading="__('API tokens')" :subheading="__('Personal tokens to read your account and notifications through the FloraHub API.')">
        <div class="space-y-8">
            <form wire:submit="createToken" class="flex items-start gap-2">
                <div class="flex-1">
                    <flux:input wire:model="token_name" :label="__('Token name')" :placeholder="__('E.g.: Postman')" />
                </div>

                <flux:button type="submit" variant="primary" class="mt-6">{{ __('Create') }}</flux:button>
            </form>

            @if ($plainTextToken)
                <div class="space-y-3 rounded-xl border border-amber-300 bg-amber-50 p-4 dark:border-amber-400/40 dark:bg-amber-400/10">
                    <flux:text class="font-medium text-amber-900! dark:text-amber-200!">{{ __('Copy the token now: it will not be shown again.') }}</flux:text>
                    <flux:input :value="$plainTextToken" readonly copyable class="font-mono" />
                </div>
            @endif

            <div>
                <flux:heading>{{ __('Your tokens') }}</flux:heading>

                <ul class="mt-3 divide-y divide-zinc-200 rounded-xl border border-zinc-200 dark:divide-zinc-700 dark:border-zinc-700">
                    @forelse ($this->tokens as $token)
                        <li wire:key="token-{{ $token->id }}" class="flex items-center justify-between gap-4 px-4 py-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-zinc-900 dark:text-white">{{ $token->name }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ __('Created :date', ['date' => $token->created_at?->format('d/m/Y H:i')]) }}
                                    ·
                                    {{ $token->last_used_at ? __('Last used :date', ['date' => $token->last_used_at->diffForHumans()]) : __('Never used') }}
                                </p>
                            </div>

                            <flux:button size="sm" variant="ghost" icon="trash" wire:click="confirmRevoke({{ $token->id }})">{{ __('Revoke') }}</flux:button>
                        </li>
                    @empty
                        <li class="px-4 py-6 text-center text-sm text-zinc-500 dark:text-zinc-400">{{ __('You have no tokens.') }}</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </x-pages::settings.layout>

    <livewire:confirm-modal />
</section>
