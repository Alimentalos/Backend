<?php

namespace App\Http\Requests\Near\Resource;

use Alimentalos\Relationships\Rules\Coordinate;
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
            'coordinates' => ['required', new Coordinate()],
        ];
    }
}
