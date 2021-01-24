<?php

namespace App\Providers;

use App\Passport\AuthCode;
use App\Passport\Client;
use App\Passport\PersonalAccessClient;
use App\Passport\Token;
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
        'App\Models\Device' => 'Alimentalos\Relationships\Policies\DevicePolicy',
        'App\Models\Geofence' => 'Alimentalos\Relationships\Policies\GeofencePolicy',
        'App\Models\Pet' => 'Alimentalos\Relationships\Policies\PetPolicy',
        'App\Models\Group' => 'Alimentalos\Relationships\Policies\GroupPolicy',
        'App\Models\Photo' => 'Alimentalos\Relationships\Policies\PhotoPolicy',
        'App\Models\Comment' => 'Alimentalos\Relationships\Policies\CommentPolicy',
        'App\Models\Action' => 'Alimentalos\Relationships\Policies\ActionPolicy',
        'App\Models\Alert' => 'Alimentalos\Relationships\Policies\AlertPolicy',
        'App\Models\Location' => 'Alimentalos\Relationships\Policies\LocationPolicy',
        'App\Models\Place' => 'Alimentalos\Relationships\Policies\PlacePolicy',
        'App\Models\User' => 'Alimentalos\Relationships\Policies\UserPolicy',
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
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));


        Passport::enableImplicitGrant();
        // Binding models
        Passport::useTokenModel(Token::class);
        Passport::useClientModel(Client::class);
        Passport::useAuthCodeModel(AuthCode::class);
        Passport::usePersonalAccessClientModel(PersonalAccessClient::class);
    }
}
