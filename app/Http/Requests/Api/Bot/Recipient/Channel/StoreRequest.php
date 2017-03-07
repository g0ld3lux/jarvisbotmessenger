<?php

namespace App\Http\Requests\Api\Bot\Recipient\Channel;

use App\Http\Requests\Api\Validate\MatcherRequest;
use Gate;

class StoreRequest extends MatcherRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('view', [$this->route('recipient'), $this->route('bot')]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'channels' => 'required',
            'channels.*.id' => 'required|exists:subscriptions_channels,id,bot_id,'.$this->route('bot')->id,
            'channels.*.type' => 'required',
        ];
    }
}
