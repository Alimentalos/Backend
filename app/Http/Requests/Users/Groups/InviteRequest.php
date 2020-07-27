<?php

namespace App\Http\Requests\Users\Groups;

use Illuminate\Foundation\Http\FormRequest;

class InviteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return authenticated()->can('inviteGroup', [$this->route('user'), $this->route('group')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ['is_admin' => 'required|boolean'];
    }
}
