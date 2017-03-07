<?php

namespace App\Http\Requests\Api\Bot\Subscription\Channel\Recipient;

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
        return Gate::allows('view', [$this->route('subscriptionChannel'), $this->route('bot')]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'recipients' => 'required',
            'recipients.*.id' => 'required|exists:recipients,id,bot_id,'.$this->route('bot')->id,
            'recipients.*.type' => 'required',
        ];
    }
}
