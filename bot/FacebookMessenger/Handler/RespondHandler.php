<?php

namespace Bot\FacebookMessenger\Handler;

use Bot\Core\Contract\Handler;
use Bot\FacebookMessenger\Jobs\ProcessEntryJob;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;
use App\Models\Communication;

class RespondHandler implements Handler
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * RespondHandler constructor.
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Determine if handler can handle incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function canHandle(Request $request)
    {
        return $request->has('entry') && $request->get('object') == 'page';
    }

    /**
     * Handle incoming request and return response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        $entries = $request->get('entry', []);

        foreach ($entries as $entry) {
            $this->dispatcher->dispatch(new ProcessEntryJob(
                array_get($entry, 'id'),
                array_get($entry, 'time'),
                (array) array_get($entry, 'messaging', [])
            ));
        }
    }
}
