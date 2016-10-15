<?php

namespace Bot\Core\Contract;

use Illuminate\Http\Request;

interface Handler
{
    /**
     * Determine if handler can handle incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function canHandle(Request $request);

    /**
     * Handle incoming request and return response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request);
}
