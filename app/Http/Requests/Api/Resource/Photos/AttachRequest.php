<?php

namespace App\Http\Requests\Api\Resource\Photos;

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
        return $this->user('api')->can('attachPhoto', [$this->route('resource'), $this->route('photo')]);
    }
}
