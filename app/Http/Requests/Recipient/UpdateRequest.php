<?php

namespace App\Http\Requests\Recipient;

use App\Http\Requests\Request;
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
        return Gate::allows('edit', [$this->route('recipient'), $this->route('bot')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'variables.timezone' => 'timezone',
        ];
    }
}
