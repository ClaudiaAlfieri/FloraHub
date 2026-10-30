<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

/**
 * Not queued: it is sent from inside the GenerateUsersReport job, which already runs on a queue worker.
 */
class UsersReportReady extends Notification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $path,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification, stored in the notifications table.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'path' => $this->path,
            'generated_at' => now()->toIso8601String(),
        ];
    }
}
