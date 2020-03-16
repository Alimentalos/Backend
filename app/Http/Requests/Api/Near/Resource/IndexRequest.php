<?php

namespace App\Http\Requests\Api\Near\Resource;

use App\Http\Requests\RuledRequest;
use Demency\Relationships\Rules\Coordinate;

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
