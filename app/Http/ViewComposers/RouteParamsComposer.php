<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RouteParamsComposer
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
        $route = $this->request->route();

        $params = [];

        if ($route) {
            $params = array_get($route->getAction(), '__rp', []);
        }

        $view->with('__rp', $params);
    }
}
