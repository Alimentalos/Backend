<?php

namespace App\Providers;

use App\Models\Alert;
use App\Models\Coin;
use App\Models\Comment;
use App\Models\Device;
use App\Models\Geofence;
use App\Models\Group;
use App\Models\Operation;
use App\Models\Pet;
use App\Models\Photo;
use App\Models\Place;
use App\Models\User;
use App\Observers\AlertObserver;
use App\Observers\ClientObserver;
use App\Observers\CoinObserver;
use App\Observers\CommentObserver;
use App\Observers\DeviceObserver;
use App\Observers\GeofenceObserver;
use App\Observers\GroupObserver;
use App\Observers\OperationObserver;
use App\Observers\PetObserver;
use App\Observers\PhotoObserver;
use App\Observers\PlaceObserver;
use App\Observers\UserObserver;
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
