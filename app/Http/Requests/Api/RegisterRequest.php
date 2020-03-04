<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\RuledRequest;

class RegisterRequest extends RuledRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ];
    }
}
