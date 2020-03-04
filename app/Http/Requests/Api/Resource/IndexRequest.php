<?php

namespace App\Http\Requests\Api\Resource;

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
        return $this->user('api')->can('viewAny', finder('resourceModelClass', finder('detectType')));
    }
}
