<?php

namespace App\Http\Requests\Api\Token;

use App\Http\Requests\RuledRequest;

class IndexRequest extends RuledRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ];
    }
}
