<?php

namespace App\Policies;

use App\Models\Industrial_area;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class Industrial_area_policy
{
    const PORTAL_MANAGER = 'Portal_manager';
    const INDUSTRIAL_REPRESENTATIVE = 'Industrial_area_representative';

    /**
     * Determine whether the user can view any models.
     */
    public function view_all(User $user): bool
    {
        return $user->stakeholder_type==$this::PORTAL_MANAGER;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Industrial_area $industrialArea): bool
    {
        return $user->stakeholder_type==$this::PORTAL_MANAGER;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->stakeholder_type==$this::PORTAL_MANAGER;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Industrial_area $industrialArea): bool
    {
        return $user->stakeholder_type==$this::PORTAL_MANAGER;
    }

    /**
     *  Get all user belong to this industrial area
     */
    public function view_subdomain_users(User $user, Industrial_area $industrialArea)
    {
        return $user->stakeholder_type == $this::INDUSTRIAL_REPRESENTATIVE && $user->id == $industrialArea->user_id;
    }

}
