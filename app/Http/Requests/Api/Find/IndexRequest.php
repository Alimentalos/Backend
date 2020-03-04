<?php

namespace App\Http\Requests\Api\Find;

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
            'type' => 'required',
            'identifiers' => 'required',
            'accuracy' => 'required',
        ];
    }
}
