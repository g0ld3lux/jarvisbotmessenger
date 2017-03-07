<?php

namespace App\Http\Requests\Api\Bot\Flow;

use App\Http\Requests\Request;
use Gate;

class ImportRequest extends Request
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
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|flows_file',
        ];
    }
}
