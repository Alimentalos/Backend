<?php

namespace App\Http\Requests\Api\Resource;

use App\Http\Requests\AuthorizedRequest;

class ShowRequest extends AuthorizedRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return authenticated()->can('view', $this->route('resource'));
    }
}
