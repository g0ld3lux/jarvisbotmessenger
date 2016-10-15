<?php

namespace App\Http\Requests\Api\Flow;

use App\Http\Requests;
use Gate;

class SortRequest extends Requests\Request
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sort' => 'required|array',
            'sort.*.flow' => 'required|exists:flows,id,project_id,'.$this->route('project')->id,
            'sort.*.position' => 'required|integer',
        ];
    }
}
