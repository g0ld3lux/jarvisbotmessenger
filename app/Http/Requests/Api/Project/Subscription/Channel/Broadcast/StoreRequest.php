<?php

namespace App\Http\Requests\Api\Project\Subscription\Channel\Broadcast;

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
        return Gate::allows('view', [$this->route('channel'), $this->route('project')]);
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
            'respond' => 'required|exists:responds,id,project_id,' . $this->route('project')->id,
            'interval' => 'integer|min:1',
            'scheduled_at' => 'required|date',
            'timezone' => 'required|in:recipient,project',
        ];
    }
}
