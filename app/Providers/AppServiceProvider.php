<?php

namespace App\Providers;

use App\Alert;
use App\Comment;
use App\Device;
use App\Group;
use App\Observers\AlertObserver;
use App\Observers\CommentObserver;
use App\Observers\DeviceObserver;
use App\Observers\GroupObserver;
use App\Observers\PetObserver;
use App\Observers\UserObserver;
use App\Pet;
use App\User;
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
        User::observe(UserObserver::class);
        Comment::observe(CommentObserver::class);
        Device::observe(DeviceObserver::class);
        Group::observe(GroupObserver::class);
        Pet::observe(PetObserver::class);
        Alert::observe(AlertObserver::class);
    }
}
