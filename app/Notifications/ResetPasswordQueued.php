<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordQueued extends ResetPassword implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance, sent through the notifications queue.
     */
    public function __construct(#[\SensitiveParameter] string $token)
    {
        parent::__construct($token);

        $this->onQueue('notifications');
    }
}
