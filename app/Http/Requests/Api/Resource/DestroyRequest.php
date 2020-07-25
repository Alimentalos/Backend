<?php

namespace App\Http\Requests\Api\Resource;

use App\Http\Requests\AuthorizedRequest;

class DestroyRequest extends AuthorizedRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return authenticated()->can('delete', $this->route('resource'));
    }
}
