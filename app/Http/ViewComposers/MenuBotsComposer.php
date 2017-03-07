<?php

namespace App\Http\ViewComposers;

use App\Models\Bot;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MenuBotsComposer
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $bots = [];

        if ($this->request->user()) {
            $bots = Bot::where('user_id', $this->request->user()->id)->orderBy('title', 'asc')->get();
        }

        $view->with('__menu_bots', $bots);
    }
}
