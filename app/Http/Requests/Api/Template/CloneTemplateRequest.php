<?php

namespace App\Http\Requests\Api\Template;

use App\Http\Requests\Request;
use Gate;

class CloneTemplateRequest extends Request
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'templates' => 'required',
        ];
    }
}
