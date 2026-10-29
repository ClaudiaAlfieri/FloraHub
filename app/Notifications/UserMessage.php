<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserMessage extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The number of times each channel's job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying: 10 s after the first failure, 60 s after the second.
     *
     * @var array<int, int>
     */
    public array $backoff = [10, 60];

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $subject,
        public string $body,
    ) {
        $this->onQueue('notifications');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->greeting(__('Hello, :name!', ['name' => $notifiable->name]))
            ->line($this->body)
            ->action(__('View notifications'), route('notifications.index'));
    }

    /**
     * Get the array representation of the notification, stored in the notifications table.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'subject' => $this->subject,
            'body' => $this->body,
        ];
    }

    /**
     * Handle a job that failed after all its attempts.
     */
    public function failed(Throwable $exception): void
    {
        Log::error('User message failed', ['exception' => $exception::class]);
    }
}
