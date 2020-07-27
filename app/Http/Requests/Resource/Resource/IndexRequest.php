<?php

namespace App\Http\Requests\Resource\Resource;

use App\Http\Requests\AuthorizedRequest;

class IndexRequest extends AuthorizedRequest
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
