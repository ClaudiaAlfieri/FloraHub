<?php

namespace App\Policies;

use App\Models\Species;
use App\Models\User;

class SpeciesPolicy
{
    /**
     * Determine whether the user can view the list of species.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the species, including a soft deleted one.
     */
    public function view(User $user, Species $species): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create species.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the species. Soft deleted species can not be updated.
     */
    public function update(User $user, Species $species): bool
    {
        return $user->hasRole('admin') && ! $species->trashed();
    }

    /**
     * Determine whether the user can soft delete the species. It must not be soft deleted already.
     */
    public function delete(User $user, Species $species): bool
    {
        return $user->hasRole('admin') && ! $species->trashed();
    }

    /**
     * Determine whether the user can restore the species. Only soft deleted species can be restored.
     */
    public function restore(User $user, Species $species): bool
    {
        return $user->hasRole('admin') && $species->trashed();
    }

    /**
     * Determine whether the user can permanently delete the species. Only soft deleted species can be permanently deleted.
     */
    public function forceDelete(User $user, Species $species): bool
    {
        return $user->hasRole('admin') && $species->trashed();
    }
}
