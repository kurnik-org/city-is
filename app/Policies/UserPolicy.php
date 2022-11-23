<?php

namespace App\Policies;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @param int $to_role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model, $to_role)
    {
        if (in_array($model->id, UserSeeder::never_delete_user_ids())) {
            return false;
        }

        if ($user->getRole() == User::getRoleId('admin')) {
            return true;
        } else {
            if ($user->getRoleAsString() == 'city_admin' && in_array($model->getRoleAsString(), ['citizen', 'technician'])) {
                if (in_array($to_role, ['citizen', 'technician'])) {
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        if (in_array($model->id, UserSeeder::never_delete_user_ids())) {
            return false;
        }

        if ($user->getRole() == User::getRoleId('admin')) {
            return true;
        } else {
            return false;
        }
    }
}
