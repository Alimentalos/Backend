<?php

namespace App\Http\Requests\Api\Resource\Geofences;

use App\Http\Requests\AuthorizedRequest;

class AttachRequest extends AuthorizedRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return authenticated()->can('attachGeofence', [$this->route('resource'), $this->route('geofence')]);
    }
}
