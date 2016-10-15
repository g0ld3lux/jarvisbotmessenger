<?php

namespace App\Http\Requests\Api\Project\Subscription\Channel;

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
        return Gate::allows('view', $this->route('project'));
    }
}
