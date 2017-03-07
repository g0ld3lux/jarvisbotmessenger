<?php

namespace App\Http\Requests\Api\Bot\Subscription\Channel;

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
        return Gate::allows('edit', [$this->route('subscriptionChannel'), $this->route('bot')]);
    }
}
