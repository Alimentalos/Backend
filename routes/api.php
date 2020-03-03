<?php

use Illuminate\Http\Request;

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
    Route::post('/device/locations', 'Api\Resource\LocationsController')->name('device.locations');
});

/**
 * Pet authenticated routes ...
 */
Route::middleware(['auth:pets'])->group(function () {
    Route::post('/pet/locations', 'Api\Resource\LocationsController')->name('pet.locations');
});

/**
 * Non authenticated routes ...
 */
Route::middleware(['api'])->group(function () {

    Route::get('/token', 'Api\TokenController')
        ->middleware(['throttle:10']);

    Route::post('/register', 'Api\RegisterController')
        ->middleware('throttle:5');

    Route::post('/password-recovery', 'Api\PasswordRecoveryController')
        ->middleware('throttle:5');
});


/**
 * Authenticated and verified routes ...
 */
Route::middleware(['auth:api', 'verified'])->group(function () {

    foreach([
        'groups', 'locations', 'actions', 'geofences', 'pets', 'devices', 'users', 'photos', 'comments', 'alerts'
            ] as $resource) {
        Route::get("/{$resource}/{resource}", 'Api\Resource\ShowController')
            ->name("{$resource}.show");
    }

    foreach([
        'users', 'groups', 'geofences', 'pets', 'devices', 'photos', 'actions', 'alerts'
            ] as $resource) {
        Route::get("/{$resource}", 'Api\Resource\IndexController')
            ->name("{$resource}.index");
    }

    Route::get('/locations', 'Api\Locations\IndexController')
        ->name('locations.index');


    // Groups Resources

    foreach (['geofences', 'groups'] as $resource) {
        Route::get("/{$resource}/{resource}/users", 'Api\Resource\Users\IndexController')
            ->name("{$resource}.users.index");
    }

    foreach(['groups', 'users'] as $resource) {
        Route::get("/{$resource}/{resource}/pets", 'Api\Resource\Pets\IndexController')
            ->name("{$resource}.pets.index");
    }

    /**
     * Groups routes ...
     */

    /**
     * Geofences routes ...
     */


    // Geofences Groups
    // TODO - Add tests for geofence group attaching and implements routes as resource geofences
    Route::get('/geofences/{resource}/groups', 'Api\Resource\Groups\IndexController')
        ->name('geofences.groups.index');

    // Geofences Accesses
    foreach(['devices', 'users', 'pets'] as $resource) {
        Route::get('/geofences/{geofence}/{resource}/accesses', 'Api\Geofences\Resource\AccessesController')
            ->name("geofences.{$resource}.accesses");
    }

    /**
     * Pets routes ...
     */

    /**
     * Devices routes ...
     */

    // Resource Devices

    foreach(['groups', 'users'] as $resource) {
        Route::get("/{$resource}/{resource}/devices", 'Api\Resource\Devices\IndexController')
            ->name("{$resource}.devices.index");
    }

    // Resource Photos

    foreach (['pets', 'geofences', 'users', 'groups'] as $resource) {
        Route::get("/{$resource}/{resource}/photos", 'Api\Resource\Photos\IndexController')
            ->name("{$resource}.photos.index");
        Route::post("/{$resource}/{resource}/photos", 'Api\Resource\Photos\StoreController')
            ->name("{$resource}.photos.store");
    }

    // Resource Geofences

    foreach (['devices', 'users', 'groups', 'pets'] as $resource) {
        Route::get("/{$resource}/{resource}/geofences", 'Api\Resource\Geofences\IndexController')
            ->name("{$resource}.geofences.index");
        Route::post("/{$resource}/{resource}/geofences/{geofence}/attach", 'Api\Resource\Geofences\AttachController')
            ->name("{$resource}.geofences.attach");
        Route::post("/{$resource}/{resource}/geofences/{geofence}/detach", 'Api\Resource\Geofences\DetachController')
            ->name("{$resource}.geofences.detach");
    }

    // Resource Comments

    foreach(['pets', 'photos', 'comments', 'alerts', 'groups'] as $resource) {
        Route::get("/{$resource}/{resource}/comments", 'Api\Resource\Comments\IndexController')
            ->name("{$resource}.comments.index");
        Route::post("/{$resource}/{resource}/comments", 'Api\Resource\Comments\StoreController')
            ->name("{$resource}.comments.store");
    }

    // Resource Groups

    foreach(['pets', 'devices', 'users'] as $resource) {
        Route::get("/{$resource}/{resource}/groups", 'Api\Resource\Groups\IndexController')
            ->name("{$resource}.groups.index");
        Route::post("/{$resource}/{resource}/groups/{group}/attach", 'Api\Resource\Groups\AttachController')
            ->name("{$resource}.groups.attach");
        Route::post("/{$resource}/{resource}/groups/{group}/detach", 'Api\Resource\Groups\DetachController')
            ->name("{$resource}.groups.detach");
    }

    // Resource Geofences

    foreach(['pets', 'devices', 'users'] as $resource) {
        Route::get("/{$resource}/{resource}/geofences/accesses", 'Api\Resource\Geofences\AccessesController')
            ->name("{$resource}.geofences.accesses");
        Route::get("/{$resource}/{resource}/geofences/{geofence}/accesses", 'Api\Resource\Geofences\Accesses\IndexController')
            ->name("{$resource}.geofences.accesses.index");
    }

    /**
     * Users routes ...
     */

    Route::get('/user', 'Api\UserController');
    Route::post('/user/locations', 'Api\Resource\LocationsController')->name('user.locations');

    // User Groups

    Route::post('/users/{user}/groups/{group}/invite', 'Api\Users\Groups\InviteController');
    Route::post('/users/{user}/groups/{group}/accept', 'Api\Users\Groups\AcceptController');
    Route::post('/users/{user}/groups/{group}/reject', 'Api\Users\Groups\RejectController');
    Route::post('/users/{user}/groups/{group}/block', 'Api\Users\Groups\BlockController');

    // Resource Reactions

    foreach (['geofences', 'pets', 'users', 'photos', 'comments'] as $resource) {
        Route::get("/{$resource}/{resource}/reactions", 'Api\Resource\Reactions\IndexController')
            ->name("{$resource}.reactions.index");
        Route::post("/{$resource}/{resource}/reactions", 'Api\Resource\Reactions\StoreController')
            ->name("{$resource}.reactions.store");
    }

    /**
     * Reports routes ...
     */
    Route::get('/reports', 'Api\ReportsController');

    /**
     * Photos routes
     */

    foreach(['users', 'pets', 'groups', 'geofences', 'devices', 'alerts'] as $resource) {
        Route::post("/{resource}", 'Api\Resource\StoreController')
            ->name("{$resource}.store");
    }

    // Resource delete routes ...
    foreach(['photos', 'users', 'comments', 'actions', 'devices', 'pets', 'geofences', 'groups', 'alerts'] as $resource) {
        Route::delete("/{$resource}/{resource}", 'Api\Resource\DestroyController')
            ->name("{$resource}.destroy");
    }


    /**
     * Comments routes
     */

    /**
     * Find route ...
     */
    Route::get('/find', 'Api\FindController');

    /**
     * Near route ...
     */
    Route::get('/near/{resource}', 'Api\Near\Resource\IndexController');

    /**
     * Alerts routes ...
     */
    foreach(['alerts', 'comments', 'photos', 'users', 'devices', 'pets', 'groups', 'geofences'] as $resource) {
        Route::put("/{$resource}/{resource}", 'Api\Resource\UpdateController')
            ->name("{$resource}.update");
    }
});
