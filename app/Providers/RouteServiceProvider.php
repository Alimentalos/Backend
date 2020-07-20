<?php

namespace App\Providers;

use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
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
    public const HOME = '/';

    /**
     * The current available dynamic path binds for your application.
     */
    public const DYNAMIC_RESOURCE_BINDS = ['resource', 'nested'];

    /**
     * The current available resources for your application.
     */
    public const CURRENT_SUPPORTED_RESOURCES = [
        'places',
        'users',
        'devices',
        'pets',
        'geofences',
        'comments',
        'groups',
        'alerts',
        'actions',
        'photos',
        'accesses',
        'locations'
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

        Route::bind('resource', function ($value) { return $this->finderCallback($value); });

        Route::model('user', User::class);
        Route::model('group', Group::class);
    }

    /**
     * Finder router callback.
     * @param $value
     * @param $resource
     * @return Builder|Model|mixed
     */
    public function finderCallback($value)
    {
        if (in_array($value, self::CURRENT_SUPPORTED_RESOURCES))
            return finder()->findClass($value);

        return finder()->findModelInstance(finder()->currentResource(), $value);
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
