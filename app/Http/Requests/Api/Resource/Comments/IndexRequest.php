<?php

namespace App\Http\Requests\Api\Resource\Comments;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $parameters = array_keys($this->route()->parameters());
        return $this->user('api')->can('view', $this->route($parameters[0]));
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
