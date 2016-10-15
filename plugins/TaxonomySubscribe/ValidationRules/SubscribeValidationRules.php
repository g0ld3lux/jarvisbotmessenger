<?php

namespace Plugins\TaxonomySubscribe\ValidationRules;

use App\Contracts\TaxonomyValidationRules;
use Illuminate\Http\Request;

class SubscribeValidationRules implements TaxonomyValidationRules
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
            'channel' => 'required|exists:subscriptions_channels,id,project_id,'.$this->request->route('project')->id,
            'option' => 'required|in:add,remove',
        ];
    }
}
