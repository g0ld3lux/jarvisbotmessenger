<?php

namespace App\Http\ViewComposers;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MenuProjectsComposer
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
        $projects = [];

        if ($this->request->user()) {
            $projects = Project::where('user_id', $this->request->user()->id)->orderBy('title', 'asc')->get();
        }

        $view->with('__menu_projects', $projects);
    }
}
