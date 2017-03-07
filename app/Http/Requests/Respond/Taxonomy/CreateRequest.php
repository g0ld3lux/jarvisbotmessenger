<?php

namespace App\Http\Requests\Respond\Taxonomy;

use Gate;

class CreateRequest extends Request
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
}
