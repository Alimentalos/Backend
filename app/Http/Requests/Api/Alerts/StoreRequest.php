<?php

namespace App\Http\Requests\Api\Alerts;

use App\Alert;
use App\Repositories\StatusRepository;
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
        return $this->user('api')->can('create', Alert::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'body' => 'required',
            'type' => [
                'required',
                Rule::in([
                    StatusRepository::CREATED,
                    StatusRepository::PUBLISHED,
                    StatusRepository::FOUNDED,
                    StatusRepository::RESOLVED,
                    StatusRepository::CLOSED
                ])
            ],
            'photo' => 'required',
            'coordinates' => ['required', new Coordinate()],
        ];
    }
}
