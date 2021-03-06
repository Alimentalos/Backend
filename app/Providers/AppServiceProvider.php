<?php

namespace App\Providers;

use Alimentalos\Relationships\Models\Alert;
use Alimentalos\Relationships\Models\Coin;
use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\Operation;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\Place;
use Alimentalos\Relationships\Models\User;
use Alimentalos\Relationships\Observers\AlertObserver;
use Alimentalos\Relationships\Observers\ClientObserver;
use Alimentalos\Relationships\Observers\CoinObserver;
use Alimentalos\Relationships\Observers\CommentObserver;
use Alimentalos\Relationships\Observers\DeviceObserver;
use Alimentalos\Relationships\Observers\GeofenceObserver;
use Alimentalos\Relationships\Observers\GroupObserver;
use Alimentalos\Relationships\Observers\OperationObserver;
use Alimentalos\Relationships\Observers\PetObserver;
use Alimentalos\Relationships\Observers\PhotoObserver;
use Alimentalos\Relationships\Observers\PlaceObserver;
use Alimentalos\Relationships\Observers\UserObserver;
use App\Passport\Client;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Solution observers
        User::observe(UserObserver::class);
        Comment::observe(CommentObserver::class);
        Device::observe(DeviceObserver::class);
        Group::observe(GroupObserver::class);
        Pet::observe(PetObserver::class);
        Alert::observe(AlertObserver::class);
        Client::observe(ClientObserver::class);
        Geofence::observe(GeofenceObserver::class);
        Photo::observe(PhotoObserver::class);
        Place::observe(PlaceObserver::class);
        Coin::observe(CoinObserver::class);
        Operation::observe(OperationObserver::class);
    }
}
