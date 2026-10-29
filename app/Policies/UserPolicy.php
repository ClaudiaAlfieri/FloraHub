<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view the list of users.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the details of another user.
     */
    public function view(User $user, User $model): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can send a message to another user.
     *
     * An administrator cannot send a message to themselves.
     */
    public function notify(User $user, User $model): bool
    {
        return $user->hasRole('admin') && $user->isNot($model);
    }
}
