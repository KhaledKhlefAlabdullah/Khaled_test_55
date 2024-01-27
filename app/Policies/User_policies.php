<?php

namespace App\Policies;

use App\Models\User;

class User_policies
{
    const PORTAL_MANAGER = 'Portal_manager';

    const INDUSTRIAL_REPRESENTATIVE = 'Industrial_area_representative';

    const TENANT_COMPANY = 'Tenant_company';

    const INFRASTRUCTURE_PROVIDER = 'Infrastructure_provider';

    const GOVERNMENT_REPRESENTATIVE = 'Government_representative';


    public function portal_manager_policy(User $user): bool
    {
        return $user->stakeholder_type == $this::PORTAL_MANAGER;
    }

    public function industrial_area_policy(User $user)
    {
        return $user->stakeholder_type == $this::INDUSTRIAL_REPRESENTATIVE && !empty($user->industrial_area_id);
    }

    public function tenant_company_policy(User $user)
    {
        return $user->stakeholder_type == $this::TENANT_COMPANY;
    }

    public function infrastructure_provider_policy(User $user)
    {
        return $user->stakeholder_type == $this::INFRASTRUCTURE_PROVIDER;
    }

    public function government_representative_policy(User $user)
    {
        return $user->stakeholder_type == $this::GOVERNMENT_REPRESENTATIVE;
    }

    public function all_users_expect_portal_manager(User $user)
    {
        return $user->stakeholder_type != $this::PORTAL_MANAGER;
    }
}
