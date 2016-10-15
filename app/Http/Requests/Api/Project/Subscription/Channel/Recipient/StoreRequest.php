<?php

namespace App\Http\Requests\Api\Project\Subscription\Channel\Recipient;

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
        return Gate::allows('view', [$this->route('subscriptionChannel'), $this->route('project')]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'recipients' => 'required',
            'recipients.*.id' => 'required|exists:recipients,id,project_id,'.$this->route('project')->id,
            'recipients.*.type' => 'required',
        ];
    }
}
