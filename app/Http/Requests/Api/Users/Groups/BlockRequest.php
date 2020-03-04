<?php

namespace App\Http\Requests\Api\Users\Groups;

use App\Http\Requests\AuthorizedRequest;

class BlockRequest extends AuthorizedRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('blockGroup', [$this->route('user'), $this->route('group')]);
    }
}
