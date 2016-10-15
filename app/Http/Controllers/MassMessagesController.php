<?php

namespace App\Http\Controllers;

use App\Models\Mass\Message;
use App\Models\Project;

class MassMessagesController extends Controller
{
    /**
     * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $this->authorize('view', $project);

        return view('projects.messages.index', [
            'project' => $project,
        ]);
    }

    /**
     * @param Project $project
     * @param Message $message
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Project $project, Message $message)
    {
        $this->authorize('view', [$message, $project]);

        return view('projects.messages.show', [
            'project' => $project,
            'message' => $message,
        ]);
    }
}
