<?php

namespace App\Http\Requests\Bot;

use App\Http\Requests;
use Gate;

class WelcomeMessageRequest extends Requests\Request
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
            'respond_id' =>
                'exists:responds,id,label,NULL,bot_id,'.$this->route('bot')->id,
        ];
    }
}
