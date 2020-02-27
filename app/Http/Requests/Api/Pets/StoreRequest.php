<?php

namespace App\Http\Requests\Api\Pets;

use App\Pet;
use App\Repositories\PetsRepository;
use App\Rules\Coordinate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('create', Pet::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // TODO - Validate born at in format
        return [
            'name' => 'required',
            'photo' => 'required',
            'is_public' => 'required|boolean',
            'hair_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'left_eye_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'right_eye_color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'size' => [
                Rule::in([
                    PetsRepository::SIZE_EXTRA_SMALL,
                    PetsRepository::SIZE_SMALL,
                    PetsRepository::SIZE_MEDIUM,
                    PetsRepository::SIZE_LARGE,
                    PetsRepository::SIZE_EXTRA_LARGE
                ])
            ],
            'born_at' => 'required',
            'coordinates' => ['required', new Coordinate()],
        ];
    }
}
