<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Respond;
use Illuminate\Database\Eloquent\Collection;

class ProjectRespondController extends Controller
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

        return $project->responds()->orderBy('title', 'asc')->global()->get();
    }

    /**
     * @param Project $project
     * @param Respond $respond
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Project $project, Respond $respond)
    {
        $this->authorize('delete', [$respond, $project]);

        $respond->delete();

        return response()->json(['success' => true]);
    }
}
