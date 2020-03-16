<?php

namespace App\Providers;

use App\Passport\Client;
use Demency\Relationships\Models\Alert;
use Demency\Relationships\Models\Coin;
use Demency\Relationships\Models\Comment;
use Demency\Relationships\Models\Device;
use Demency\Relationships\Models\Geofence;
use Demency\Relationships\Models\Group;
use Demency\Relationships\Models\Operation;
use Demency\Relationships\Models\Pet;
use Demency\Relationships\Models\Photo;
use Demency\Relationships\Models\Place;
use Demency\Relationships\Models\User;
use Demency\Relationships\Observers\AlertObserver;
use Demency\Relationships\Observers\ClientObserver;
use Demency\Relationships\Observers\CoinObserver;
use Demency\Relationships\Observers\CommentObserver;
use Demency\Relationships\Observers\DeviceObserver;
use Demency\Relationships\Observers\GeofenceObserver;
use Demency\Relationships\Observers\GroupObserver;
use Demency\Relationships\Observers\OperationObserver;
use Demency\Relationships\Observers\PetObserver;
use Demency\Relationships\Observers\PhotoObserver;
use Demency\Relationships\Observers\PlaceObserver;
use Demency\Relationships\Observers\UserObserver;
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
