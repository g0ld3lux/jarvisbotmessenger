<?php

namespace App\Http\Requests\Recipient\Variable;

use App\Http\Requests;
use Gate;
use Illuminate\Support\Str;

abstract class Request extends Requests\Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|in:text',
            'name' => 'required|recipient_variable_accessor:'.$this->route('project')->id,
        ];
    }
}
