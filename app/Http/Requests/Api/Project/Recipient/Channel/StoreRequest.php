<?php

namespace App\Http\Requests\Api\Project\Recipient\Channel;

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
        return Gate::allows('view', [$this->route('recipient'), $this->route('project')]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'channels' => 'required',
            'channels.*.id' => 'required|exists:subscriptions_channels,id,project_id,'.$this->route('project')->id,
            'channels.*.type' => 'required',
        ];
    }
}
