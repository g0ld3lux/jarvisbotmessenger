<?php

namespace Bot\FacebookMessenger\Handler;

use Bot\Core\Contract\Handler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationHandler implements Handler
{
    /**
     * Determine if handler can handle incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function canHandle(Request $request)
    {
        if ($request->get('hub_mode') == 'subscribe' && $request->has('hub_verify_token')) {
            return true;
        }

        return false;
    }

    /**
     * Handle incoming request and return response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        if ($request->get('hub_verify_token') == config('services.bot.verification_token')) {
            return (new Response())->setContent($request->get('hub_challenge'));
        }

        return (new Response())->setContent('Error: token mismatch');
    }
}
