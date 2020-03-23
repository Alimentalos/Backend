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
        'Alimentalos\Relationships\Models\Device' => 'Alimentalos\Relationships\Policies\DevicePolicy',
        'Alimentalos\Relationships\Models\Geofence' => 'Alimentalos\Relationships\Policies\GeofencePolicy',
        'Alimentalos\Relationships\Models\Pet' => 'Alimentalos\Relationships\Policies\PetPolicy',
        'Alimentalos\Relationships\Models\Group' => 'Alimentalos\Relationships\Policies\GroupPolicy',
        'Alimentalos\Relationships\Models\Photo' => 'Alimentalos\Relationships\Policies\PhotoPolicy',
        'Alimentalos\Relationships\Models\Comment' => 'Alimentalos\Relationships\Policies\CommentPolicy',
        'Alimentalos\Relationships\Models\Action' => 'Alimentalos\Relationships\Policies\ActionPolicy',
        'Alimentalos\Relationships\Models\Alert' => 'Alimentalos\Relationships\Policies\AlertPolicy',
        'Alimentalos\Relationships\Models\Location' => 'Alimentalos\Relationships\Policies\LocationPolicy',
        'Alimentalos\Relationships\Models\Place' => 'Alimentalos\Relationships\Policies\PlacePolicy',
        'Alimentalos\Relationships\Models\User' => 'Alimentalos\Relationships\Policies\UserPolicy',
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
