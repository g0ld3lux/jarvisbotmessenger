<?php

namespace App\Http\Requests\Recipient\Variable;

use Gate;

class UpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('edit', [$this->route('recipientVariable'), $this->route('project')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'name' => 'required|'
                .'recipient_variable_accessor:'.$this->route('project')->id.','.$this->route('recipientVariable')->id,
        ]);
    }
}
