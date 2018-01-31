<?php

namespace KW\Transactions\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'KW\Transactions\Model' => 'KW\Transactions\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('manage-transaction', function($user) {
            return $user->hasRole([
                // 'agent',
                'kwri_business_admin',
                'kwri_executive',
                'kwri_support',
                // 'lead_agent',
                'mc_investor',
                // 'mc_mca',
                'mc_op',
                'mc_staff',
                'mc_team_leader',
                'mc_tech_coordinator',
                'non_producing_team_member',
                'producing_team_member',
                'region_admin',
                'region_director',
                'region_investor',
                // 'region_mca',
                'region_op',
                'region_staff',
                'region_tech_manager',
                'super_admin'
            ]);
        });

        $gate->define('reject-draft-transaction', function($user) {
            return true;
        });
    }
}
