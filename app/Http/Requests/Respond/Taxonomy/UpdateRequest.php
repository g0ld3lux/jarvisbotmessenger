<?php

namespace App\Http\Requests\Respond\Taxonomy;

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
        return Gate::allows('edit', [$this->route('respond'), $this->route('project')]);
    }
}
