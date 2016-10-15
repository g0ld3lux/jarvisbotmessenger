<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Validate\MatcherRequest;

class ValidateController extends Controller
{
    /**
     * Validate new matcher.
     *
     * @param MatcherRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateMatcher(MatcherRequest $request)
    {
        return response()->json(['success' => true]);
    }
}
