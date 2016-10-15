<?php

namespace App\Http\Controllers;

use Bot\Core\Processor;
use Illuminate\Http\Request;

class IncomingController extends Controller
{
    /**
     * @var Processor
     */
    protected $processor;

    /**
     * IncomingController constructor.
     * @param Processor $processor
     */
    public function __construct(Processor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Process incoming request.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function process(Request $request)
    {
        return $this->processor->handler($request)->handle($request);
    }
}
