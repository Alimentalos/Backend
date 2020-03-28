<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\AuthorizedRequest;

class RefreshRequest extends AuthorizedRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'refresh_token' => 'required',
        ];
    }
}
