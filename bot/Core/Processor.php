<?php

namespace Bot\Core;

use Bot\Core\Contract\Handler;
use Illuminate\Http\Request;

class Processor
{
    /**
     * @var string
     */
    const TAG = 'bot.core.processor.handler';

    /**
     * Available handlers.
     *
     * @var \Bot\Core\Contract\Handler[]
     */
    protected $handlers = [];

    /**
     * Add new handler.
     *
     * @param Handler $handler
     */
    public function addHandler(Handler $handler)
    {
        $this->handlers[] = $handler;
    }

    /**
     * @param Request $request
     * @return Handler
     * @throws \Exception
     */
    public function handler(Request $request)
    {
        foreach ($this->handlers as $handler) {
            if ($handler->canHandle($request)) {
                return $handler;
            }
        }

        throw new \Exception('Can\'t handle incoming request...');
    }
}
