<?php

namespace App\Http\Requests\Api\Pets\Geofences;

use Illuminate\Foundation\Http\FormRequest;

class DetachRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('detachGeofence', [
            $this->route('pet'), $this->route('geofence')
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
