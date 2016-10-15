<?php

namespace App\Http\Controllers;

use App\Http\Requests\Recipient\Variable\CreateRequest;
use App\Http\Requests\Recipient\Variable\UpdateRequest;
use App\Models\Project;
use App\Models\Recipient;
use App\Models\Communication;
use Illuminate\Support\Str;
use Notification;

class RecipientsVariablesController extends Controller
{
    /**
     * Show links list.
     *
     * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $this->authorize('view', $project);

        $recipientsVariables = $project->recipientsVariables()->orderBy('name', 'asc')->get();

        return view('projects.recipients.variables.index', [
            'project' => $project,
            'recipientsVariables' => $recipientsVariables,
        ]);
    }

    /**
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Project $project)
    {
        $this->authorize('view', $project);

        return view('projects.recipients.variables.create', [
            'project' => $project,
        ]);
    }

    /**
     * @param CreateRequest $request
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request, Project $project)
    {
        $this->authorize('view', $project);

        $recipientVariable = new Recipient\Variable([
            'name' => $request->get('name'),
            'accessor' => Str::slug($request->get('name')),
            'type' => $request->get('type'),
        ]);

        $recipientVariable->project()->associate($project);

        $recipientVariable->save();

        Notification::success('Recipient variable added successfully.');

        return redirect()->route('projects.recipients.variables.index', $project->id);
    }

    /**
     * @param Project $project
     * @param Recipient\Variable $variable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Project $project, Recipient\Variable $variable)
    {
        $this->authorize('edit', [$variable, $project]);

        return view('projects.recipients.variables.edit', [
            'project' => $project,
            'recipientVariable' => $variable,
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @param Project $project
     * @param Recipient\Variable $variable
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Project $project, Recipient\Variable $variable)
    {
        $this->authorize('edit', [$variable, $project]);

        $variable->fill([
            'name' => $request->get('name'),
            'accessor' => Str::slug($request->get('name')),
            'type' => $request->get('type'),
        ]);

        $variable->save();

        Notification::success('Recipient variable updated successfully');

        return redirect()->route('projects.recipients.variables.index', $project->id);
    }

    public function delete(Project $project, Recipient\Variable $variable)
    {
        $this->authorize('delete', [$variable, $project]);

        $variable->delete();

        Notification::success('Recipient variable deleted successfully.');

        return redirect()->route('projects.recipients.variables.index', $project->id);
    }
}
