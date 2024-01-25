<?php

namespace App\Policies;

use App\Models\Industrial_area;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class Portal_manager_policy
{
    const PORTAL_MANAGER = 'Portal_manager';

    /**
     * Determine whether the user can view any models.
     */
    public function view_details_create_update(User $user): bool
    {
        return $user->stakeholder_type == $this::PORTAL_MANAGER;
    }

}
