<?php

namespace App\Http\Requests\Api\Bot\Message;

use App\Http\Requests\Request;
use Gate;

class StoreRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('view', $this->route('bot'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'responds' => 'required|min:1',
            'responds.*' => 'exists:responds,id,label,NULL,bot_id,'.$this->route('bot')->id,
            'recipients.*' => 'exists:recipients,id,bot_id,'.$this->route('bot')->id,
            'interval' => 'integer|min:1',
            'scheduled_at' => 'required|date',
            'timezone' => 'required|in:recipient,bot',
        ];
    }
}
