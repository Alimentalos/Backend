<?php

namespace App\Http\Requests\Api\Geofences;

use App\Rules\Coordinate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('update', $this->route('geofence'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'is_public' => 'boolean',
            'coordinates' => [
                Rule::requiredIf(function () {
                    return $this->has('photo');
                }), new Coordinate()
            ],
        ];
    }
}
