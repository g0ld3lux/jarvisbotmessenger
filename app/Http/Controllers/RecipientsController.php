<?php

namespace App\Http\Controllers;

use App\Http\Requests\Recipient\UpdateRequest;
use App\Jobs\Recipients\AssignVariablesJob;
use App\Models\Project;
use App\Models\Recipient;
use App\Models\Communication;
use Illuminate\Contracts\Bus\Dispatcher;
use Notification;

class RecipientsController extends Controller
{
    /**
     * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $this->authorize('view', $project);

        return view('projects.recipients.index', [
            'project' => $project,
        ]);
    }

    /**
     * Show project dashboard.
     *
     * @param Project $project
     * @param Recipient $recipient
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Project $project, Recipient $recipient)
    {
        $this->authorize('view', [$recipient, $project]);

        return view('projects.recipients.show', [
            'project' => $project,
            'recipient' => $recipient,
        ]);
    }

    /**
     * @param Project $project
     * @param Recipient $recipient
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Project $project, Recipient $recipient)
    {
        $this->authorize('edit', [$recipient, $project]);

        $recipientVariables = Recipient\Variable\Relation::with('variable', 'values')
            ->where('recipient_id', $recipient->id)
            ->get()
            ->keyBy(function (Recipient\Variable\Relation $relation) {
                return $relation->variable->accessor;
            });

        return view('projects.recipients.edit', [
            'project' => $project,
            'recipient' => $recipient,
            'recipientVariables' => $recipientVariables,
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @param Dispatcher $dispatcher
     * @param Project $project
     * @param Recipient $recipient
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Dispatcher $dispatcher, Project $project, Recipient $recipient)
    {
        $this->authorize('edit', [$recipient, $project]);

        $dispatcher->dispatchNow(new AssignVariablesJob($recipient, (array) $request->get('variables', [])));

        Notification::success('Recipient updated successfully.');

        return redirect()->route('projects.recipients.show', [$project->id, $recipient->id]);
    }
}
