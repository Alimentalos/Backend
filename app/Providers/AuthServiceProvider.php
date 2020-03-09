<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Device' => 'App\Policies\DevicePolicy',
        'App\Geofence' => 'App\Policies\GeofencePolicy',
        'App\Pet' => 'App\Policies\PetPolicy',
        'App\Group' => 'App\Policies\GroupPolicy',
        'App\Photo' => 'App\Policies\PhotoPolicy',
        'App\Comment' => 'App\Policies\CommentPolicy',
        'App\Action' => 'App\Policies\ActionPolicy',
        'App\Alert' => 'App\Policies\AlertPolicy',
        'App\Location' => 'App\Policies\LocationPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensExpireIn(now()->addDays(15));

        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
