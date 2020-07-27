<?php

namespace App\Http\Requests\Resource\Geofences;

use App\Http\Requests\AuthorizedRequest;

class DetachRequest extends AuthorizedRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return authenticated()->can('detachGeofence', [$this->route('resource'), $this->route('geofence')]);
    }
}
