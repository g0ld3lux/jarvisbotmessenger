<?php

namespace App\Http\Controllers;

use App\Http\Requests\Respond\Taxonomy\CreateRequest;
use App\Http\Requests\Respond\Taxonomy\UpdateRequest;
use App\Jobs\Responds\Taxonomies\AssignParamsJob;
use App\Jobs\Responds\Taxonomies\GetNextOrderJob;
use App\Jobs\Responds\Taxonomies\MoveDownJob;
use App\Jobs\Responds\Taxonomies\MoveUpJob;
use App\Models\Project;
use App\Models\Respond;
use Illuminate\Contracts\Bus\Dispatcher;
use Notification;

class TaxonomiesController extends Controller
{
    const ACTION_CREATE = 'create';

    /**
     * @var array
     */
    protected static $extensions = [];

    /**
     * @param $action
     * @param $type
     * @param \Closure $callback
     */
    public static function extend($action, $type, \Closure $callback)
    {
        $key = $action.'.'.$type;

        if (array_has(static::$extensions, $key)) {
            throw new \InvalidArgumentException('Type "'.$type.'" already has a callback');
        }

        array_set(static::$extensions, $key, $callback);
    }

    /**
     * @param Project $project
     * @param Respond $respond
     * @param null $type
     * @param Respond\Taxonomy $parent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Project $project, Respond $respond, $type = null, $parent = null)
    {
        $this->authorize('edit', [$respond, $project]);

        if (!is_null($parent)) {
            $parent = $respond->taxonomies()->findOrFail($parent);
        }

        if (!is_null($type)) {
            $extensionKey = static::ACTION_CREATE.'.'.$type;

            if (array_has(static::$extensions, $extensionKey)) {
                return call_user_func_array(
                    array_get(static::$extensions, $extensionKey),
                    [$project, $respond, $type, $parent]
                );
            }
        }

        return view('projects.responds.taxonomies.create'.(is_null($type) ? '' : '.'.$type), [
            'project' => $project,
            'respond' => $respond,
            'type' => $type,
            'parent' => $parent,
        ]);
    }

    /**
     * @param CreateRequest $request
     * @param Dispatcher $dispatcher
     * @param Project $project
     * @param Respond $respond
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request, Dispatcher $dispatcher, Project $project, Respond $respond)
    {
        $this->authorize('edit', [$respond, $project]);

        $taxonomy = new Respond\Taxonomy([
            'type' => $request->get('type'),
            'order' => $dispatcher->dispatchNow(new GetNextOrderJob($respond, $request->get('parent')))
        ]);

        if ($request->has('parent')) {
            $taxonomy->parent()->associate(Respond\Taxonomy::findOrFail($request->get('parent')));
        }

        $taxonomy->respond()->associate($respond);

        $taxonomy->save();

        $dispatcher->dispatchNow(new AssignParamsJob($taxonomy, $request));

        Notification::success('Element added successfully.');

        if ($taxonomy->parent) {
            return redirect()->route('projects.responds.edit.taxonomies.edit', [
                $project->id,
                $respond->id,
                $taxonomy->parent_id
            ]);
        }

        return redirect()->route('projects.responds.edit', [$project->id, $respond->id]);
    }

    /**
     * @param Project $project
     * @param Respond $respond
     * @param Respond\Taxonomy $taxonomy
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function edit(Project $project, Respond $respond, Respond\Taxonomy $taxonomy)
    {
        $this->authorize('edit', [$taxonomy, $respond, $project]);

        return view('projects.responds.taxonomies.edit.'.$taxonomy->type, [
            'project' => $project,
            'respond' => $respond,
            'taxonomy' => $taxonomy,
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @param Dispatcher $dispatcher
     * @param Project $project
     * @param Respond $respond
     * @param Respond\Taxonomy $taxonomy
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        UpdateRequest $request,
        Dispatcher $dispatcher,
        Project $project,
        Respond $respond,
        Respond\Taxonomy $taxonomy
    ) {
        $this->authorize('edit', [$taxonomy, $respond, $project]);

        $taxonomy->touch();

        $dispatcher->dispatchNow(new AssignParamsJob($taxonomy, $request));

        Notification::success('Element added successfully.');

        return redirect()->route('projects.responds.edit', [$project->id, $respond->id]);
    }

    /**
     * Delete link.
     *
     * @param Project $project
     * @param Respond $respond
     * @param Respond\Taxonomy $taxonomy
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Project $project, Respond $respond, Respond\Taxonomy $taxonomy)
    {
        $this->authorize('delete', [$taxonomy, $respond, $project]);

        $taxonomy->delete();

        Notification::success('Element deleted successfully.');

        return redirect()->route('projects.responds.edit', [$project->id, $respond->id]);
    }

    /**
     * Delete link.
     *
     * @param Dispatcher $dispatcher
     * @param Project $project
     * @param Respond $respond
     * @param Respond\Taxonomy $taxonomy
     * @return \Illuminate\Http\RedirectResponse
     */
    public function moveUp(Dispatcher $dispatcher, Project $project, Respond $respond, Respond\Taxonomy $taxonomy)
    {
        $this->authorize('edit', [$taxonomy, $respond, $project]);

        $dispatcher->dispatchNow(new MoveUpJob($taxonomy));

        Notification::success('Element moved successfully.');

        return redirect()->back();
    }

    /**
     * Delete link.
     *
     * @param Dispatcher $dispatcher
     * @param Project $project
     * @param Respond $respond
     * @param Respond\Taxonomy $taxonomy
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function moveDown(Dispatcher $dispatcher, Project $project, Respond $respond, Respond\Taxonomy $taxonomy)
    {
        $this->authorize('edit', [$taxonomy, $respond, $project]);

        $dispatcher->dispatchNow(new MoveDownJob($taxonomy));

        Notification::success('Element moved successfully.');

        return redirect()->back();
    }
}
