<?php

namespace Plugins\TaxonomySaveInput\ValidationRules;

use App\Contracts\TaxonomyValidationRules;
use Illuminate\Http\Request;

class SaveInputValidationRules implements TaxonomyValidationRules
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * SaveInputValidationRules constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Return array of validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'variable' => 'required|exists:recipients_variables,id,project_id,'.$this->request->route('project')->id,
        ];
    }
}
