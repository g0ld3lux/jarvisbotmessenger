<?php

namespace App\Http\Controllers;

use App\Http\Requests\Respond\UpdateRequest;
use App\Models\Project;
use App\Models\Respond;
use Carbon\Carbon;
use Notification;

class RespondsController extends Controller
{
    /**
     * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $this->authorize('view', $project);

        return view('projects.responds.index', ['project' => $project]);
    }

    /**
     * Show new link form.
     *
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Project $project)
    {
        $this->authorize('view', $project);

        $respond = new Respond([
            'title' => 'Draft v.'.adjust_project_timezone($project, new Carbon())->format('F j, Y, g:i A'),
        ]);
        $respond->project()->associate($project);
        $respond->save();

        return redirect()->route('projects.responds.edit', [$project->id, $respond->id]);
    }

    /**
     * Edit matcher.
     *
     * @param Project $project
     * @param Respond $respond
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Project $project, Respond $respond)
    {
        $this->authorize('edit', [$respond, $project]);

        return view('projects.responds.edit', [
            'project' => $project,
            'respond' => $respond,
            'taxonomies' => $respond->taxonomies()->ofRoot()->ordered()->get(),
        ]);
    }

    /**
     * Update matcher.
     *
     * @param UpdateRequest $request
     * @param Project $project
     * @param Respond $respond
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Project $project, Respond $respond)
    {
        $this->authorize('edit', [$respond, $project]);

        $respond->fill(['title' => $request->get('title')]);

        $respond->save();

        Notification::success('Respond updated successfully.');

        return redirect()->route('projects.responds.edit', [$project->id, $respond->id]);
    }

    /**
     * Delete link.
     *
     * @param Project $project
     * @param Respond $respond
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Project $project, Respond $respond)
    {
        $this->authorize('delete', [$respond, $project]);

        $respond->delete();

        Notification::success('Respond deleted successfully.');

        return redirect()->route('projects.responds.index', $project->id);
    }
}
