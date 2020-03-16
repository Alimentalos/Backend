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
        'Demency\Relationships\Models\Device' => 'Demency\Relationships\Policies\DevicePolicy',
        'Demency\Relationships\Models\Geofence' => 'Demency\Relationships\Policies\GeofencePolicy',
        'Demency\Relationships\Models\Pet' => 'Demency\Relationships\Policies\PetPolicy',
        'Demency\Relationships\Models\Group' => 'Demency\Relationships\Policies\GroupPolicy',
        'Demency\Relationships\Models\Photo' => 'Demency\Relationships\Policies\PhotoPolicy',
        'Demency\Relationships\Models\Comment' => 'Demency\Relationships\Policies\CommentPolicy',
        'Demency\Relationships\Models\Action' => 'Demency\Relationships\Policies\ActionPolicy',
        'Demency\Relationships\Models\Alert' => 'Demency\Relationships\Policies\AlertPolicy',
        'Demency\Relationships\Models\Location' => 'Demency\Relationships\Policies\LocationPolicy',
        'Demency\Relationships\Models\Place' => 'Demency\Relationships\Policies\PlacePolicy',
        'Demency\Relationships\Models\User' => 'Demency\Relationships\Policies\UserPolicy',
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
