<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmailQueued extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance, sent through the notifications queue.
     */
    public function __construct()
    {
        $this->onQueue('notifications');
    }
}
