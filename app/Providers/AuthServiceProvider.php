<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Device' => 'App\Policies\DevicePolicy',
        'App\Geofence' => 'App\Policies\GeofencePolicy',
        'App\Pet' => 'App\Policies\PetPolicy',
        'App\Group' => 'App\Policies\GroupPolicy',
        'App\Photo' => 'App\Policies\PhotoPolicy',
        'App\Comment' => 'App\Policies\CommentPolicy',
        'App\Action' => 'App\Policies\ActionPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
