<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // return false;
        // return $user->role === 'admin';
        return in_array($user->role, ['admin', 'editor']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $userx)
    {
        return $user->id === $userx->user_id || $user->role === 'admin';
    }

    public function delete(User $user, User $userx)
    {
        return $user->id === $userx->user_id || $user->role === 'admin';
    }

    public function view(User $user, User $userx)
    {
        return true; // Everyone can view
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $userx): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
