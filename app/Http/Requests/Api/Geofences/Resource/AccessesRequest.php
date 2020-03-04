<?php

namespace App\Http\Requests\Api\Geofences\Resource;

use App\Http\Requests\AuthorizedRequest;

class AccessesRequest extends AuthorizedRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('view', $this->route('geofence'));
    }
}
