<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use App\Models\Device;
use App\Models\Geofence;
use App\Models\Pet;
use App\Models\User;

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('geofences.{geofence}', function ($user, Geofence $geofence) {
    if ($user->can('view', $geofence)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
});

Broadcast::channel('locations.{trackableType}.{trackableId}', function ($user, $trackableType, $trackableId) {
    if ($trackableType === 'users') {
        if ($user->can('view', User::where('uuid', $trackableId)->first())) {
            return ['id' => $user->id, 'name' => $user->name];
        } else {
            return false;
        }
    } elseif ($trackableType === 'pets') {
        if ($user->can('view', Pet::where('uuid', $trackableId)->first())) {
            return ['id' => $user->id, 'name' => $user->name];
        } else {
            return false;
        }
    } elseif ($trackableType === 'devices') {
        if ($user->can('view', Device::where('uuid', $trackableId)->first())) {
            return ['id' => $user->id, 'name' => $user->name];
        } else {
            return false;
        }
    }
    return false;
});
