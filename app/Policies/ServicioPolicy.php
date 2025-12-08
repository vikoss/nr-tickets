<?php

namespace App\Policies;

use App\Models\Servicio;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicioPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any services.
     * Admin: can view all services.
     * Tecnico: can only view their own services (filtered in controller).
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'tecnico']);
    }

    /**
     * Determine whether the user can view the service.
     * Admin: can view any service.
     * Tecnico: can only view their own services.
     */
    public function view(User $user, Servicio $servicio): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->id === $servicio->user_id;
    }

    /**
     * Determine whether the user can create services.
     * Both admin and tecnico can create services.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'tecnico']);
    }

    /**
     * Determine whether the user can update the service.
     * No one can edit a service after creation.
     */
    public function update(User $user, Servicio $servicio): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the service.
     * Only admin can delete services.
     */
    public function delete(User $user, Servicio $servicio): bool
    {
        return $user->hasRole('admin');
    }
}
