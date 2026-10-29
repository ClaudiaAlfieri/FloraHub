<?php

namespace App\Policies;

use App\Models\Family;
use App\Models\User;

class FamilyPolicy
{
    /**
     * Determine whether the user can view the list of families.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the family, including a soft deleted one.
     */
    public function view(User $user, Family $family): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create families.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the family. It must not be soft deleted.
     */
    public function update(User $user, Family $family): bool
    {
        return $user->hasRole('admin') && ! $family->trashed();
    }

    /**
     * Determine whether the user can soft delete the family. It must not be soft deleted already.
     */
    public function delete(User $user, Family $family): bool
    {
        return $user->hasRole('admin') && ! $family->trashed();
    }

    /**
     * Determine whether the user can restore the family. Only soft deleted families can be restored.
     */
    public function restore(User $user, Family $family): bool
    {
        return $user->hasRole('admin') && $family->trashed();
    }

    /**
     * Determine whether the user can permanently delete the family. Only soft deleted families
     * without species (including soft deleted species) can be permanently deleted.
     */
    public function forceDelete(User $user, Family $family): bool
    {
        return $user->hasRole('admin')
            && $family->trashed()
            && ! $family->species()->withTrashed()->exists();
    }
}
