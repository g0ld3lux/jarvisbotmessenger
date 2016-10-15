<?php

namespace App\Http\Requests\Admin\Users;

use App\Http\Requests\Request;
use Gate;

class CreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('permission', 'access.admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'max:255',
            'email' => 'required|max:255|unique:users,email',
            'password' => 'required',
            'permissions.*' => 'exists:permissions,id',
        ];
    }
}
