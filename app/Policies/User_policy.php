<?php

namespace App\Policies;

use App\Models\Industrial_area;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class User_policy
{
    // todo i will continue in
    const INDUSTRIAL_REPRESENTATIVE = 'Industrial_area_representative';

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        //
    }

    /**
     *  Get all user belong to this industrial area
     */
    public function view_subdomain_users(User $user, Industrial_area $industrialArea)
    {
        return $user->stakeholder_type == $this::INDUSTRIAL_REPRESENTATIVE && $user->id == $industrialArea->user_id;
    }
}
