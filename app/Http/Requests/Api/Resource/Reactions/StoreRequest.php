<?php

namespace App\Http\Requests\Api\Resource\Reactions;

use App\Repositories\HandleBindingRepository;
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
        return $this->user('api')->can('view', $this->route('resource'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $options = HandleBindingRepository::bindResource(get_class($this->route('resource')))::AVAILABLE_REACTIONS;
        return [
            'type' => 'required|in:' . $options
        ];
    }
}
