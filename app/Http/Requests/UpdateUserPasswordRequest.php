<?php

namespace App\Http\Requests;

use Gate;

class UpdateUserPasswordRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required|max:255|old_password:'.$this->user()->password,
            'new_password' => 'required|confirmed|min:6',
        ];
    }
}
