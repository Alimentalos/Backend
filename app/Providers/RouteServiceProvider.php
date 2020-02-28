<?php

namespace App\Providers;

use App\Device;
use App\Group;
use App\Pet;
use App\Photo;
use App\User;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

        Route::bind('resource', function ($value) {
            if (in_array($value, ['users', 'devices', 'pets', 'geofences']))
                return $value;


            switch (Request::route()->getName()) {
                case 'photos.comments.store':
                    return Photo::where('uuid', $value)->first() ?? abort(404);
                    break;
                case 'groups.comments.store':
                    return Group::where('uuid', $value)->first() ?? abort(404);
                    break;
                case 'users.geofences.accesses.index':
                case 'users.comments.store':
                    return User::where('uuid', $value)->first() ?? abort(404);
                    break;
                case 'devices.geofences.accesses.index':
                    return Device::where('uuid', $value)->first() ?? abort(404);
                case 'pets.comments.store':
                default:
                    return Pet::where('uuid', $value)->first() ?? abort(404);
                    break;
            }
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
