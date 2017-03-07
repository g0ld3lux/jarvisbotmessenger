<?php

namespace App\Http\Requests;

use Gate;

class DeleteBotRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('delete', $this->route('bot'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'delete_title' => 'required|in:'.$this->route('bot')->title,
        ];
    }
}
