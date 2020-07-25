<?php

namespace App\Http\Requests;

use App\Http\Requests\RuledRequest;

class PasswordRecoveryRequest extends RuledRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email'
        ];
    }
}
