<?php

namespace App\Policies;

use App\Models\Registration_request;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class Registration_request_policy
{
    const INDUSTRIAL_REPRESENTATIVE = 'Industrial_area_representative';

    /**
     * Determine whether the user can view any models.
     */
    public function view_or_details_or_accept_denied(User $user): bool
    {
        return $user->stakeholder_type == $this::INDUSTRIAL_REPRESENTATIVE;
    }

}
