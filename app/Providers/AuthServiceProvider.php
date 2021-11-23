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
        'App\Models\Device' => 'App\Policies\DevicePolicy',
        'App\Models\Geofence' => 'App\Policies\GeofencePolicy',
        'App\Models\Pet' => 'App\Policies\PetPolicy',
        'App\Models\Group' => 'App\Policies\GroupPolicy',
        'App\Models\Photo' => 'App\Policies\PhotoPolicy',
        'App\Models\Comment' => 'App\Policies\CommentPolicy',
        'App\Models\Action' => 'App\Policies\ActionPolicy',
        'App\Models\Alert' => 'App\Policies\AlertPolicy',
        'App\Models\Location' => 'App\Policies\LocationPolicy',
        'App\Models\Place' => 'App\Policies\PlacePolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
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
