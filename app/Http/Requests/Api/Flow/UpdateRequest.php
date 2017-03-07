<?php

namespace App\Http\Requests\Api\Flow;

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
        return Gate::allows('edit', [$this->route('flow'), $this->route('bot')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'responds.*.id' => 'exists:responds,id,label,NULL,bot_id,'.$this->route('bot')->id,
        ];
    }
}
