<?php

namespace App\Http\Requests\Api\Locations;

use App\Http\Requests\RuledRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'accuracy' => 'required',
            'start_date' => 'required|date:Y-m-d H:m:s',
            'end_date' => 'required|date:Y-m-d H:m:s',
            'identifiers' => 'required',
            'type' => 'required',
            'api_token' => 'required',
        ];
    }

    /**
     * Failed validation disable redirect
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
