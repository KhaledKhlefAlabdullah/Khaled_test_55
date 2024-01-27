<?php

namespace App\Providers;

use App\Models\Industrial_area;
use App\Models\Registration_request;
use App\Models\User;
use App\Policies\Portal_manager_policy;
use App\Policies\Industrial_area_representative_policy;
use App\Policies\User_policies;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
//        Registration_request::class => Industrial_area_representative_policy::class,
//        Industrial_area::class => Portal_manager_policy::class,
        User::class => User_policies::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        //
    }
}
