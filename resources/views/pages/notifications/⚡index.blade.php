<?php

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts::user')] #[Title('Notifications')] class extends Component {
    use WithPagination;

    /**
     * The authenticated user's notifications, the most recent first.
     *
     * @return LengthAwarePaginator<int, DatabaseNotification>
     */
    #[Computed]
    public function notifications(): LengthAwarePaginator
    {
        return auth()->user()->notifications()->paginate(10);
    }

    /**
     * Mark one of the user's notifications as read.
     *
     * The notification is searched through the relationship, so a user can only mark their own.
     * The page is reloaded so that the counters in the layout, outside this component, are updated.
     */
    public function markAsRead(string $id): void
    {
        auth()->user()->notifications()->findOrFail($id)->markAsRead();

        $this->redirectRoute('notifications.index');
    }

    /**
     * Mark all the user's unread notifications as read.
     */
    public function markAllAsRead(): void
    {
        auth()->user()->unreadNotifications->markAsRead();

        $this->redirectRoute('notifications.index');
    }
};
?>

<div>
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-stone-900">{{ __('Notifications') }}</h2>
            <p class="mt-1 text-sm text-stone-500">{{ __('Messages sent to you by the FloraHub team.') }}</p>
        </div>

        @if (auth()->user()->unreadNotifications()->exists())
            <flux:button size="sm" icon="check" wire:click="markAllAsRead">{{ __('Mark all as read') }}</flux:button>
        @endif
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl border border-stone-200 bg-white">
        <ul class="divide-y divide-stone-200">
            @forelse ($this->notifications as $notification)
                <li wire:key="{{ $notification->id }}" @class([
                    'flex items-start gap-4 px-6 py-4',
                    'bg-brand-50/60' => $notification->unread(),
                ])>
                    <span @class([
                        'mt-1.5 h-2 w-2 flex-none rounded-full',
                        'bg-brand-600' => $notification->unread(),
                        'bg-stone-300' => $notification->read(),
                    ])></span>

                    <div class="min-w-0 flex-1">
                        <p @class(['text-sm text-stone-900', 'font-semibold' => $notification->unread()])>{{ $notification->data['subject'] ?? '' }}</p>
                        <p class="mt-1 whitespace-pre-line text-sm text-stone-600">{{ $notification->data['body'] ?? '' }}</p>
                        <p class="mt-2 text-xs text-stone-500">{{ $notification->created_at?->diffForHumans() }}</p>
                    </div>

                    @if ($notification->unread())
                        <flux:button size="sm" variant="ghost" wire:click="markAsRead('{{ $notification->id }}')">{{ __('Mark as read') }}</flux:button>
                    @endif
                </li>
            @empty
                <li class="px-6 py-10 text-center text-sm text-stone-500">{{ __('No notifications') }}</li>
            @endforelse
        </ul>

        @if ($this->notifications->hasPages())
            <div class="border-t border-stone-200 px-6 py-4">
                {{ $this->notifications->links() }}
            </div>
        @endif
    </div>
</div>
