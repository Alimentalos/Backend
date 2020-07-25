<?php

namespace App\Http\Requests\Api\Resource\Reactions;


use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return authenticated()->can('view', $this->route('resource'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ['type' => 'required|in:' . $this->route('resource')->getAvailableReactions()];
    }
}
