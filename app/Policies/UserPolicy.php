<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any users.
     * Only admin can view all users (for user management).
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     * Users can view their own profile, admin can view anyone.
     */
    public function view(User $user, User $model): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can create users.
     * Only admin can create new users (technicians).
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     * Users can update their own profile, admin can update anyone.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     * Only admin can delete users, but cannot delete themselves.
     */
    public function delete(User $user, User $model): bool
    {
        if (!$user->hasRole('admin')) {
            return false;
        }

        // Admin cannot delete themselves
        return $user->id !== $model->id;
    }

    /**
     * Determine whether the user can manage roles.
     * Only admin can assign/modify roles.
     */
    public function manageRoles(User $user): bool
    {
        return $user->hasRole('admin');
    }
}
