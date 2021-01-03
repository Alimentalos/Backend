<?php

use Illuminate\Http\Request;
use Illuminate\Support\Str;

\Igaster\LaravelCities\Geo::ApiRoutes();

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:devices'])->group(function () {
    Route::post('/device/locations', 'Resource\LocationsController')->name('api.device.locations');
});

/**
 * Pet authenticated routes ...
 */
Route::middleware(['auth:pets'])->group(function () {
    Route::post('/pet/locations', 'Resource\LocationsController')->name('api.pet.locations');
});

/**
 * Non authenticated routes ...
 */
Route::middleware(['api'])->group(function () {
    Route::post('/register', 'RegisterController')
        ->middleware('throttle:5');

    Route::get('/reverse-geocoding', 'ReverseGeocodingController')
        ->middleware('throttle:5');

    Route::post('/password-recovery', 'PasswordRecoveryController')
        ->middleware('throttle:5');

    Route::post('/token', 'TokenController')
        ->middleware('throttle:10');

    Route::post('/refresh', 'RefreshController')
        ->middleware('throttle:10');

});


/**
 * Authenticated and verified routes ...
 */
Route::middleware(['auth:api', 'verified'])->group(function () {

    foreach(config('resources.listable') as $resource) {
        Route::get("/{$resource}", 'Resource\IndexController')
            ->name("api.{$resource}.index");
        Route::get("/{resource}/search", 'Resource\SearchController')
            ->name("api.{$resource}.search");
    }

    foreach(config('resources.tokenized') as $resource) {
        Route::get("/{$resource}/{resource}/token", 'Resource\TokenController')
            ->name("api.{$resource}.token");
    }

    foreach(config('resources.storable') as $resource) {
        Route::post("/{resource}", 'Resource\StoreController')
            ->name("api.{$resource}.store");
    }

    foreach(config('resources.viewable') as $resource) {
        Route::get("/{$resource}/{resource}", 'Resource\ShowController')
            ->name("api.{$resource}.show");
    }

    foreach(config('resources.modifiable') as $resource) {
        Route::put("/{$resource}/{resource}", 'Resource\UpdateController')
            ->name("api.{$resource}.update");
    }

    foreach(config('resources.removable') as $key => $resource) {
        Route::delete("/{$key}/{resource}", 'Resource\DestroyController')
            ->name("api.{$key}.destroy");
    }

    Route::get('/locations', 'Locations\IndexController')
        ->name('api.locations.index');

    foreach (['geofences', 'groups'] as $resource) {
        Route::get("/{$resource}/{resource}/{nested}", 'Resource\Nested\IndexController')
            ->name("api.{$resource}.users.index");
    }

    foreach (['users'] as $resource) {
        Route::get("/{$resource}/{resource}/{nested}", 'Resource\Nested\IndexController')
            ->name("api.{$resource}.places.index");
    }

    foreach(['groups', 'users'] as $resource) {
        Route::get("/{$resource}/{resource}/{nested}", 'Resource\Nested\IndexController')
            ->name("{$resource}.pets.index");
        Route::get("/{$resource}/{resource}/{nested}", 'Resource\Nested\IndexController')
            ->name("api.{$resource}.devices.index");
    }

    foreach(['devices', 'users', 'pets'] as $resource) {
        Route::get('/geofences/{geofence}/{resource}/accesses', 'Geofences\Resource\AccessesController')
            ->name("api.geofences.{$resource}.accesses");
        Route::get("/{$resource}/{resource}/accesses", 'Resource\AccessesController')
            ->name("api.{$resource}.accesses");
        Route::get("/{$resource}/{resource}/geofences/{geofence}/accesses", 'Resource\Geofences\Accesses\IndexController')
            ->name("api.{$resource}.geofences.accesses.index");
    }

    foreach (['places', 'pets', 'geofences', 'users', 'groups'] as $resource) {
        Route::get("/{$resource}/{resource}/{nested}", 'Resource\Nested\IndexController')
            ->name("api.{$resource}.photos.index");
        Route::post("/{$resource}/{resource}/photos", 'Resource\Photos\StoreController')
            ->name("api.{$resource}.photos.store");
        Route::post("/{$resource}/{resource}/photos/{photo}/attach", 'Resource\Photos\AttachController')
            ->name("api.{$resource}.photos.attach");
        Route::post("/{$resource}/{resource}/photos/{photo}/detach", 'Resource\Photos\DetachController')
            ->name("api.{$resource}.photos.detach");
    }

    // Resource Geofences

    foreach (['devices', 'users', 'pets'] as $resource) {
        Route::get("/{$resource}/{resource}/{nested}", 'Resource\Nested\IndexController')
			->name("api.{$resource}.geofences.index");
        Route::get("/{$resource}/{resource}/{nested}", 'Resource\Nested\IndexController')
			->name("api.{$resource}.groups.index");
        Route::post("/{$resource}/{resource}/geofences/{geofence}/attach", 'Resource\Geofences\AttachController')
			->name("api.{$resource}.geofences.attach");
        Route::post("/{$resource}/{resource}/geofences/{geofence}/detach", 'Resource\Geofences\DetachController')
			->name("api.{$resource}.geofences.detach");
        Route::post("/{$resource}/{resource}/groups/{group}/attach", 'Resource\Groups\AttachController')
			->name("api.{$resource}.groups.attach");
        Route::post("/{$resource}/{resource}/groups/{group}/detach", 'Resource\Groups\DetachController')
			->name("api.{$resource}.groups.detach");
    }

    foreach(['groups', 'geofences'] as $resource) {
        if ($resource === 'geofences') {
            $str = 'groups';
        } else {
            $str = 'geofences';
        }
        Route::get("/{$resource}/{resource}/{$str}", 'Resource\Nested\IndexController')
			->name("api.{$resource}.{$str}.index");
        Route::post("/{$resource}/{resource}/{$str}/". '{' . Str::singular($str) . '}' ."/attach", 'Resource\\' . Str::ucfirst($str) . '\AttachController')->name("api.{$resource}.{$str}.attach");
        Route::post("/{$resource}/{resource}/{$str}/". '{' . Str::singular($str) . '}' ."/detach", 'Resource\\' . Str::ucfirst($str) . '\DetachController')->name("api.{$resource}.{$str}.detach");
    }

    foreach(['places', 'pets', 'photos', 'comments', 'alerts', 'groups'] as $resource) {
        Route::get("/{$resource}/{resource}/comments", 'Resource\Comments\IndexController')
            ->name("api.{$resource}.comments.index");
        Route::post("/{$resource}/{resource}/comments", 'Resource\Comments\StoreController')
            ->name("api.{$resource}.comments.store");
    }


    Route::get('/user', 'UserController');

    Route::post('/user/locations', 'Resource\LocationsController')
		->name('api.user.locations');

    foreach(['invite', 'accept', 'reject', 'block'] as $method) {
        Route::post("/users/{user}/groups/{group}/{$method}", "Users\Groups\\" . Str::ucfirst($method) . "Controller");
    }

    foreach (['geofences', 'pets', 'users', 'photos', 'comments', 'places'] as $resource) {
        Route::get("/{$resource}/{resource}/reactions", 'Resource\Reactions\IndexController')
            ->name("api.{$resource}.reactions.index");
        Route::post("/{$resource}/{resource}/reactions", 'Resource\Reactions\StoreController')
            ->name("api.{$resource}.reactions.store");
    }

    Route::get('/reports', 'ReportsController');

    Route::get('/find', 'FindController');

    Route::get('/near/{resource}', 'Near\Resource\IndexController');

});

\Igaster\LaravelCities\Geo::ApiRoutes();
