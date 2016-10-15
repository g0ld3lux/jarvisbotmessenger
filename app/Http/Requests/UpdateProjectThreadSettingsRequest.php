<?php

namespace App\Http\Requests;

use Gate;

class UpdateProjectThreadSettingsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('settings', $this->route('project'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'greeting_text' => 'required|max:160',
            'get_started_respond_id' => '',
            'persistent_menu_respond_id' => '',
        ];
    }
}
