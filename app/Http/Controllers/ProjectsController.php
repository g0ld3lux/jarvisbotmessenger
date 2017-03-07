<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConnectPageRequest;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\DeleteProjectRequest;
use App\Http\Requests\UpdateProjectDashboardRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Requests\UpdateProjectThreadSettingsRequest;
use App\Jobs\Facebook\FetchLongLivedTokenJob;
use App\Jobs\Facebook\FetchUserPagesJobs;
use App\Jobs\Facebook\SubscribeProjectJob;
use App\Models\Flow;
use App\Models\Project;
use App\Models\Communication;
use App\Models\Respond;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;
use Notification;
use Socialite;

class ProjectsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = Project::where('user_id', $request->user()->id)->orderBy('title', 'asc')->get();

        return view('projects.index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show new project form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store new project to database.
     *
     * @param CreateProjectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateProjectRequest $request)
    {
        $project = new Project([
            'title' => $request->get('title'),
            'timezone' => $request->get('timezone'),
        ]);

        $project->user()->associate($request->user());

        $project->save();

        Notification::success('Bot created successfully.');

        return redirect()->route('projects.show', $project->id);
    }

    /**
     * Show project dashboard.
     *
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        if (!$project->threadSettings) {
            $project->threadSettings()->save(new Project\Settings\Thread());
        }

        return view('projects.show', [
            'project' => $project,
        ]);
    }

    /**
     * Show project settings.
     *
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings(Project $project)
    {
        $this->authorize('settings', $project);

        $responds = Respond::select('responds.*')
            ->leftJoin('responds_taxonomies', 'responds_taxonomies.respond_id', '=', 'responds.id')
            ->whereNull('responds.label')
            ->where('responds.project_id', $project->id)
            ->where('responds_taxonomies.type', 'buttons')
            ->whereNull('responds_taxonomies.parent_id')
            ->where(
                \DB::raw(
                    '(
                        select count(responds_taxonomies.id)
                        from responds_taxonomies
                        where responds_taxonomies.respond_id = responds.id
                        and responds_taxonomies.parent_id is null
                    )'
                ),
                1
            )
            ->get();

        return view('projects.settings', [
            'project' => $project,
            'responds' => $project->responds()->global()->get(),
            'persistent_menu_responds' => $responds,
        ]);
    }

    /**
     * Update project settings.
     *
     * @param UpdateProjectRequest $request
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('settings', $project);

        $project->fill([
            'title' => $request->get('title'),
            'timezone' => $request->get('timezone'),
        ]);

        $project->save();

        Notification::success('Bot updated successfully.');

        return redirect()->route('projects.settings', $project->id);
    }

    /**
     * Update project settings.
     *
     * @param UpdateProjectDashboardRequest $request
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDashboard(UpdateProjectDashboardRequest $request, Project $project)
    {
        $this->authorize('settings', $project);

        $project->fill([
            'dashboard_active' => (bool) $request->get('dashboard_active'),
        ]);

        $project->save();

        $message = $project->dashboard_active ? 'enabled' : 'disabled';

        Notification::success('Bot dashboard '.$message.' successfully.');

        return redirect()->route('projects.settings', $project->id)->withInput(['tab' => 'dashboard']);
    }

    /**
     * @param UpdateProjectThreadSettingsRequest $request
     * @param Project $project
     * @return $this
     */
    public function updateThread(UpdateProjectThreadSettingsRequest $request, Project $project)
    {
        $this->authorize('settings', $project);

        $settings = $project->threadSettings;

        $settings->fill([
            'greeting_text' => $request->get('greeting_text'),
        ]);

        try {
            $settings->getStartedRespond()->associate(
                $project->responds()->findOrFail($request->get('get_started_respond_id'))
            );
        } catch (\Exception $e) {
            $settings->get_started_respond_id = null;
        }

        try {
            $settings->persistentMenuRespond()->associate(
                $project->responds()->findOrFail($request->get('persistent_menu_respond_id'))
            );
        } catch (\Exception $e) {
            $settings->persistent_menu_respond_id = null;
        }

        $settings->save();

        Notification::success('Bot thread settings updated successfully.');

        return redirect()->route('projects.settings', $project->id)->withInput(['tab' => 'thread']);
    }

    /**
     * Delete project.
     *
     * @param DeleteProjectRequest $request
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(DeleteProjectRequest $request, Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        Notification::success('Bot deleted successfully.');

        return redirect()->route('home');
    }
}
