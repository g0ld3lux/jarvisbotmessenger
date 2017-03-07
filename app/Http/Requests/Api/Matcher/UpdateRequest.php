<?php

namespace App\Http\Requests\Api\Matcher;

use App\Http\Requests\Api\Validate\MatcherRequest;
use Gate;

class UpdateRequest extends MatcherRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('view', [$this->route('flow'), $this->route('bot')]);
    }
}
