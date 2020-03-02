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

    /**
     * Groups routes ...
     */
    Route::get('/groups', 'Api\Groups\IndexController');
    Route::post('/groups', 'Api\Groups\StoreController');
    Route::get('/groups/{group}', 'Api\Groups\ShowController');
    Route::put('/groups/{group}', 'Api\Groups\UpdateController');
    Route::delete('/groups/{resource}', 'Api\Resource\DestroyController')
        ->name('groups.destroy');


    // Groups Resources

    Route::get('/groups/{group}/users', 'Api\Groups\Users\IndexController');
    Route::get('/groups/{group}/devices', 'Api\Groups\Devices\IndexController');
    Route::get('/groups/{group}/pets', 'Api\Groups\Pets\IndexController');

    // Groups Comments

    Route::get('/groups/{resource}/comments', 'Api\Resource\Comments\IndexController')
        ->name('groups.comments.index');
    Route::post('/groups/{resource}/comments', 'Api\Resource\Comments\StoreController')
        ->name('groups.comments.store');

    // Groups Photos

    Route::get('/groups/{resource}/photos', 'Api\Resource\Photos\IndexController')
        ->name('groups.photos.index');
    Route::post('/groups/{resource}/photos', 'Api\Resource\Photos\StoreController')
        ->name('groups.photos.store');

    // Groups Geofences

    Route::get('/groups/{resource}/geofences', 'Api\Resource\Geofences\IndexController')
        ->name('groups.geofences.index');
    Route::post('/groups/{resource}/geofences/{geofence}/attach', 'Api\Resource\Geofences\AttachController')
        ->name('groups.geofences.attach');
    Route::post('/groups/{resource}/geofences/{geofence}/detach', 'Api\Resource\Geofences\DetachController')
        ->name('groups.geofences.detach');

    /**
     * Locations routes ...
     */
    Route::get('/locations', 'Api\Locations\IndexController');
    Route::get('/locations/{location}', 'Api\Locations\ShowController');

    /**
     * Actions routes ...
     */
    Route::get('/actions', 'Api\Actions\IndexController');
    Route::get('/actions/{action}', 'Api\Actions\ShowController');
    Route::delete('/actions/{resource}', 'Api\Resource\DestroyController')
        ->name('actions.destroy');

    /**
     * Geofences routes ...
     */
    Route::get('/geofences', 'Api\Geofences\IndexController');
    Route::post('/geofences', 'Api\Geofences\StoreController');
    Route::get('/geofences/{geofence}', 'Api\Geofences\ShowController');
    Route::put('/geofences/{geofence}', 'Api\Geofences\UpdateController');
    Route::delete('/geofences/{resource}', 'Api\Resource\DestroyController')
        ->name('geofences.destroy');

    // Geofence Photos

    Route::get('/geofences/{resource}/photos', 'Api\Resource\Photos\IndexController')
        ->name('geofences.photos.index');
    Route::post('/geofences/{resource}/photos', 'Api\Resource\Photos\StoreController')
        ->name('geofences.photos.store');

    // Geofences Users

    Route::get('/geofences/{geofence}/users', 'Api\Geofences\Users\IndexController');

    // Geofences Groups
    Route::get('/geofences/{geofence}/groups', 'Api\Geofences\Groups\IndexController');

    // Geofences Reactions

    Route::get('/geofences/{geofence}/reactions', 'Api\Geofences\Reactions\IndexController');
    Route::post('/geofences/{geofence}/reactions', 'Api\Geofences\Reactions\StoreController');

    // Geofences Accesses
    Route::get('/geofences/{geofence}/devices/accesses', 'Api\Geofences\Devices\AccessesController');
    Route::get('/geofences/{geofence}/users/accesses', 'Api\Geofences\Users\AccessesController');
    Route::get('/geofences/{geofence}/pets/accesses', 'Api\Geofences\Pets\AccessesController');

    /**
     * Pets routes ...
     */
    Route::get('/pets', 'Api\Pets\IndexController');
    Route::post('/pets', 'Api\Pets\StoreController');
    Route::get('/pets/{pet}', 'Api\Pets\ShowController');
    Route::put('/pets/{pet}', 'Api\Pets\UpdateController');
    Route::delete('/pets/{resource}', 'Api\Resource\DestroyController')
        ->name('pets.destroy');

    // Pet Geofences

    Route::get('/pets/{resource}/geofences', 'Api\Resource\Geofences\IndexController')
        ->name('pets.geofences.index');
    Route::post('/pets/{resource}/geofences/{geofence}/attach', 'Api\Resource\Geofences\AttachController')
        ->name('pets.geofences.attach');
    Route::post('/pets/{resource}/geofences/{geofence}/detach', 'Api\Resource\Geofences\DetachController')
        ->name('pets.geofences.detach');

    // Pet Geofences Accesses

    Route::get('/pets/{pet}/geofences/accesses', 'Api\Pets\Geofences\AccessesController');
    Route::get('/pets/{resource}/geofences/{geofence}/accesses', 'Api\Resource\Geofences\Accesses\IndexController')
        ->name('pets.geofences.accesses.index');

    // Pet Photos

    Route::get('/pets/{resource}/photos', 'Api\Resource\Photos\IndexController')
        ->name('pets.photos.index');
    Route::post('/pets/{resource}/photos', 'Api\Resource\Photos\StoreController')
        ->name('pets.photos.store');

    // Pet Groups

    Route::get('/pets/{pet}/groups', 'Api\Pets\Groups\IndexController');
    Route::post('/pets/{pet}/groups/{group}/attach', 'Api\Pets\Groups\AttachController');
    Route::post('/pets/{pet}/groups/{group}/detach', 'Api\Pets\Groups\DetachController');

    // Pet Comments

    Route::get('/pets/{resource}/comments', 'Api\Resource\Comments\IndexController')
        ->name('pets.comments.index');
    Route::post('/pets/{resource}/comments', 'Api\Resource\Comments\StoreController')
        ->name('pets.comments.store');

    // Pet Reactions

    Route::get('/pets/{pet}/reactions', 'Api\Pets\Reactions\IndexController');
    Route::post('/pets/{pet}/reactions', 'Api\Pets\Reactions\StoreController');

    /**
     * Devices routes ...
     */
    Route::get('/devices', 'Api\Devices\IndexController');
    Route::post('/devices', 'Api\Devices\StoreController');
    Route::get('/devices/{device}', 'Api\Devices\ShowController');
    Route::put('/devices/{device}', 'Api\Devices\UpdateController');
    Route::delete('/devices/{resource}', 'Api\Resource\DestroyController')
        ->name('devices.destroy');

    // Device Geofences

    Route::get('/devices/{resource}/geofences', 'Api\Resource\Geofences\IndexController')
        ->name('devices.geofences.index');
    Route::post('/devices/{resource}/geofences/{geofence}/attach', 'Api\Resource\Geofences\AttachController')
        ->name('devices.geofences.attach');
    Route::post('/devices/{resource}/geofences/{geofence}/detach', 'Api\Resource\Geofences\DetachController')
        ->name('devices.geofences.detach');

    // Device Geofences Accesses

    Route::get('/devices/{device}/geofences/accesses', 'Api\Devices\Geofences\AccessesController');
    Route::get('/devices/{resource}/geofences/{geofence}/accesses', 'Api\Resource\Geofences\Accesses\IndexController')
        ->name('devices.geofences.accesses.index');

    // Device Groups

    Route::get('/devices/{device}/groups', 'Api\Devices\Groups\IndexController');
    Route::post('/devices/{device}/groups/{group}/attach', 'Api\Devices\Groups\AttachController');
    Route::post('/devices/{device}/groups/{group}/detach', 'Api\Devices\Groups\DetachController');

    /**
     * Users routes ...
     */

    Route::get('/user', 'Api\UserController');
    Route::post('/user/locations', 'Api\Resource\LocationsController')->name('user.locations');

    Route::get('/users', 'Api\Users\IndexController');
    Route::post('/users', 'Api\Users\StoreController');
    Route::get('/users/{user}', 'Api\Users\ShowController');
    Route::put('/users/{user}', 'Api\Users\UpdateController');
    Route::delete('/users/{resource}', 'Api\Resource\DestroyController')
        ->name('users.destroy');

    // User Groups

    Route::post('/users/{user}/groups/{group}/attach', 'Api\Users\Groups\AttachController');
    Route::post('/users/{user}/groups/{group}/detach', 'Api\Users\Groups\DetachController');
    Route::post('/users/{user}/groups/{group}/invite', 'Api\Users\Groups\InviteController');
    Route::post('/users/{user}/groups/{group}/accept', 'Api\Users\Groups\AcceptController');
    Route::post('/users/{user}/groups/{group}/reject', 'Api\Users\Groups\RejectController');
    Route::post('/users/{user}/groups/{group}/block', 'Api\Users\Groups\BlockController');

    // User Resources

    Route::get('/users/{user}/devices', 'Api\Users\Devices\IndexController');
    Route::get('/users/{user}/groups', 'Api\Users\Groups\IndexController');
    Route::get('/users/{user}/pets', 'Api\Users\Pets\IndexController');

    // User Geofences

    Route::get('/users/{resource}/geofences', 'Api\Resource\Geofences\IndexController')
        ->name('users.geofences.index');
    Route::post('/users/{resource}/geofences/{geofence}/attach', 'Api\Resource\Geofences\AttachController')
        ->name('users.geofences.attach');
    Route::post('/users/{resource}/geofences/{geofence}/detach', 'Api\Resource\Geofences\DetachController')
        ->name('users.geofences.detach');


    // User Geofences Accesses

    Route::get('/users/{resource}/geofences/{geofence}/accesses', 'Api\Resource\Geofences\Accesses\IndexController')
        ->name('users.geofences.accesses.index');
    Route::get('/users/{user}/geofences/accesses', 'Api\Users\Geofences\AccessesController');

    // User Photos

    Route::get('/users/{resource}/photos', 'Api\Resource\Photos\IndexController')
        ->name('users.photos.index');
    Route::post('/users/{resource}/photos', 'Api\Resource\Photos\StoreController')
        ->name('users.photos.store');

    // User Reactions

    Route::get('/users/{user}/reactions', 'Api\Users\Reactions\IndexController');
    Route::post('/users/{user}/reactions', 'Api\Users\Reactions\StoreController');

    /**
     * Reports routes ...
     */
    Route::get('/reports', 'Api\ReportsController');

    /**
     * Photos routes
     */
    Route::get('/photos', 'Api\Photos\IndexController');
    Route::get('/photos/{photo}', 'Api\Photos\ShowController');
    Route::put('/photos/{photo}', 'Api\Photos\UpdateController');
    Route::delete('/photos/{resource}', 'Api\Resource\DestroyController')
        ->name('photos.destroy');

    // Photo Comments routes ...

    Route::get('/photos/{resource}/comments', 'Api\Resource\Comments\IndexController')
        ->name('photos.comments.index');
    Route::post('/photos/{resource}/comments', 'Api\Resource\Comments\StoreController')
        ->name('photos.comments.store');

    // Photo Reactions routes ...

    Route::get('/photos/{photo}/reactions', 'Api\Photos\Reactions\IndexController');
    Route::post('/photos/{photo}/reactions', 'Api\Photos\Reactions\StoreController');

    /**
     * Comments routes
     */
    Route::get('/comments/{comment}', 'Api\Comments\ShowController');
    Route::put('/comments/{comment}', 'Api\Comments\UpdateController');
    Route::delete('/comments/{resource}', 'Api\Resource\DestroyController')
        ->name('comments.destroy');

    // Comment Comments routes ...

    Route::get('/comments/{resource}/comments', 'Api\Resource\Comments\IndexController')
        ->name('comments.comments.index');
    Route::post('/comments/{resource}/comments', 'Api\Resource\Comments\StoreController')
        ->name('comments.comments.store');

    // Comment Reactions routes ...

    Route::get('/comments/{comment}/reactions', 'Api\Comments\Reactions\IndexController');
    Route::post('/comments/{comment}/reactions', 'Api\Comments\Reactions\StoreController');

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
    Route::get('/alerts', 'Api\Alerts\IndexController');
    Route::post('/alerts', 'Api\Alerts\StoreController');
    Route::get('/alerts/{alert}', 'Api\Alerts\ShowController');
    Route::put('/alerts/{alert}', 'Api\Alerts\UpdateController');
    Route::delete('/alerts/{resource}', 'Api\Resource\DestroyController')
        ->name('alerts.destroy');

    Route::get('/alerts/{resource}/comments', 'Api\Resource\Comments\IndexController')
        ->name('alerts.comments.index');
    Route::post('/alerts/{resource}/comments', 'Api\Resource\Comments\StoreController')
        ->name('alerts.comments.store');
});
