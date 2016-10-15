<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Flow\SortRequest;
use App\Http\Requests\Api\Flow\StoreRequest;
use App\Http\Requests\Api\Flow\UpdateRequest;
use App\Http\Requests\Api\Project\Flow\ImportRequest;
use App\Models\Flow;
use App\Models\Project;
use App\Services\Flow\Exchange;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Storage;

class ProjectFlowController extends Controller
{
    /**
     * Return project flows.
     *
     * @param Project $project
     * @return Collection
     */
    public function index(Project $project)
    {
        $this->authorize('view', $project);

        return Flow::with('responds', 'matchers', 'matchers.params')
            ->where('project_id', $project->id)
            ->ordered()
            ->get();
    }

    /**
     * Return single flow.
     *
     * @param Project $project
     * @param Flow $flow
     * @return Flow
     */
    public function show(Project $project, Flow $flow)
    {
        $this->authorize('view', $project);

        $flow->load(['responds', 'matchers', 'matchers.params']);

        return $flow;
    }

    /**
     * Store new flow.
     *
     * @param StoreRequest $request
     * @param Project $project
     * @return Flow
     */
    public function store(StoreRequest $request, Project $project)
    {
        $this->authorize('view', $project);

        $flow = new Flow([
            'title' => $request->get('title'),
            'order' => $project->flows()->max('order') + 1,
        ]);
        $flow->project()->associate($project);
        $flow->save();

        $flow->responds()->sync(array_pluck((array) $request->get('responds', []), 'id'));

        return $flow;
    }

    /**
     * Update existing flow.
     *
     * @param UpdateRequest $request
     * @param Project $project
     * @param Flow $flow
     * @return Flow
     */
    public function update(UpdateRequest $request, Project $project, Flow $flow)
    {
        $this->authorize('edit', [$flow, $project]);

        $flow->fill(['title' => $request->get('title')]);
        $flow->save();

        $flow->responds()->sync(array_pluck((array) $request->get('responds', []), 'id'));

        return $flow;
    }

    /**
     * Delete given flow.
     *
     * @param Project $project
     * @param Flow $flow
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Project $project, Flow $flow)
    {
        $this->authorize('delete', [$flow, $project]);

        $flow->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Make flow as default.
     *
     * @param Project $project
     * @param Flow $flow
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeDefault(Project $project, Flow $flow)
    {
        $this->authorize('view', [$flow, $project]);

        $project->flows()->update(['defaulted_at' => null]);
        $flow->defaulted_at = new Carbon();
        $flow->save();

        return response()->json(['success' => true]);
    }

    /**
     * Delete default flow.
     *
     * @param Project $project
     * @param Flow $flow
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDefault(Project $project, Flow $flow)
    {
        $this->authorize('view', [$flow, $project]);

        $flow->defaulted_at = null;
        $flow->save();

        return response()->json(['success' => true]);
    }

    /**
     * Update positions.
     *
     * @param SortRequest $request
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSort(SortRequest $request, Project $project)
    {
        $this->authorize('view', $project);

        foreach ($request->get('sort') as $sort) {
            $project->flows()->where('id', $sort['flow'])->update(['order' => $sort['position']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * @param Request $request
     * @param Project $project
     * @param Exchange $exchange
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request, Project $project, Exchange $exchange)
    {
        $this->authorize('view', $project);

        if (count((array) $request->get('flows', [])) > 0) {
            $flows = $project->flows()->whereIn('id', (array) $request->get('flows', []))->ordered()->get();
        } else {
            $flows = $project->flows()->ordered()->get();
        }

        $file = 'public/export/project_'.$project->id.'.json';

        try {
            Storage::delete($file);
        } catch (\Exception $e) {
            // ignore
        }

        Storage::put($file, json_encode($exchange->export($flows->all(), 1)));

        return response()->download(storage_path('app/'.$file));
    }

    /**
     * @param ImportRequest $request
     * @param Project $project
     * @param Exchange $exchange
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(ImportRequest $request, Project $project, Exchange $exchange)
    {
        $this->authorize('view', $project);

        try {
            $data = json_decode(Storage::get('public/import/project_'.$project->id.'.json'));

            if ($exchange->import($project, $data, $data->meta->version)) {
                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
            logger($e);
        }

        return response()->json(['success' => false], 422);
    }
}
