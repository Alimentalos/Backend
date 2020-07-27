<?php

namespace App\Http\Requests;

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
//            'country' => ['required', 'integer'],
//            'country_name' => ['required', 'string'],
//            'region' => ['required', 'integer'],
//            'region_name' => ['required', 'string'],
//            'city' => ['required', 'integer'],
//            'city_name' => ['required', 'string'],
        ];
    }
}
