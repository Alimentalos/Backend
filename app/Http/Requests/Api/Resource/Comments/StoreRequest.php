<?php

namespace App\Http\Requests\Api\Resource\Comments;

use Alimentalos\Relationships\Models\Comment;
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
        return authenticated()->can('view', $this->route('resource')) && authenticated()->can('create', Comment::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return (new Comment())->storeRules($this);
    }
}
