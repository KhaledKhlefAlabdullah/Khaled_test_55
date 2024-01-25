<?php

namespace App\Policies;

use App\Models\Registration_request;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class Industrial_area_representative_policy
{
    const INDUSTRIAL_REPRESENTATIVE = 'Industrial_area_representative';

    /**
     * Determine whether the user can view any models.
     */
    public function view_or_details_or_accept_denied(User $user): bool
    {
        return $user->stakeholder_type == $this::INDUSTRIAL_REPRESENTATIVE;
    }

    public function view_subdomain_users(User $user)
    {
        return $user->stakeholder_type == $this::INDUSTRIAL_REPRESENTATIVE && !empty($user->industrial_area_id);
    }

}
