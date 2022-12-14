<?php

namespace App\Policies;

use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return in_array($user->getRole(), [User::getRoleId('admin'), User::getRoleId('city_admin'), User::getRoleId('technician')]);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ServiceRequest $serviceRequest)
    {
        return $this->viewAny($user);
    }

    public function index(User $user)
    {
        return in_array($user->getRole(), [User::getRoleId('city_admin'), User::getRoleId('technician')]);
    }

    public function index_open_closed(User $user)
    {
        return $user->getRole() == User::getRoleId('city_admin');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->getRole() == User::getRoleId('city_admin');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ServiceRequest $serviceRequest)
    {
        if ($user->getRole() == User::getRoleId('technician')) {
            return $serviceRequest->technician_id == $user->id;
        }
        else
        {
            return $user->getRole() == User::getRoleId('city_admin');
        }
    }
}
