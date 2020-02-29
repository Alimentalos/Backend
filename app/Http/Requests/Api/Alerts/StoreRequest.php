<?php

namespace App\Http\Requests\Api\Alerts;

use App\Alert;
use App\Repositories\HandleBindingRepository;
use App\Repositories\ResourceRepository;
use App\Repositories\StatusRepository;
use App\Repositories\TypeRepository;
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
            'alert_type' => [
                'required',
                Rule::in(ResourceRepository::availableResource())
            ],
            'alert_id' => [
                'required',
            ],
            'type' => [
                'required',
                Rule::in(TypeRepository::availableAlertTypes())
            ],
            'status' => [
                'required',
                Rule::in(StatusRepository::availableAlertStatuses())
            ],
            'photo' => 'required',
            'coordinates' => ['required', new Coordinate()],
        ];
    }
}
