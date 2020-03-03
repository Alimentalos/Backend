<?php

namespace App\Http\Requests\Api\Resource;

use App\Repositories\HandleBindingRepository;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('update', $this->route('resource'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return HandleBindingRepository::bindResource(get_class($this->route('resource')))::updateRules($this);
    }
}
