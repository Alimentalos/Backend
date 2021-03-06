<?php

namespace App\Http\Requests\Resource;

use App\Http\Requests\AuthorizedRequest;

class CreateRequest extends AuthorizedRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		return authenticated()->can('create', finder()->findClass(finder()->currentResource()));
    }
}
