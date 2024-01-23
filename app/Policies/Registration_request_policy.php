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
    public function view_all(User $user): bool
    {
        return $user->stakeholder_type == $this::INDUSTRIAL_REPRESENTATIVE;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Registration_request $registrationRequest): bool
    {
        return $user->stakeholder_type == $this::INDUSTRIAL_REPRESENTATIVE;
    }

    /**
     * Determine whether the user can create models.
     */
    public function accept_or_failed(User $user): bool
    {
        return $user->stakeholder_type == $this::INDUSTRIAL_REPRESENTATIVE;
    }

}
