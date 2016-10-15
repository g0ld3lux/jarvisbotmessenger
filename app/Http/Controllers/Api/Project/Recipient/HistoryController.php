<?php

namespace App\Http\Controllers\Api\Project\Recipient;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Recipient;
use Datatables;
use App\Models\Communication;

class HistoryController extends Controller
{
    /**
     * @param Project $project
     * @param Recipient $recipient
     * @return mixed
     */
    public function index(Project $project, Recipient $recipient)
    {
        $this->authorize('view', [$recipient, $project]);

        return Datatables::of(
            Communication\Log::with('flow')
                ->where('project_id', $project->id)
                ->where('recipient_id', $recipient->id)
        )->make(true);
    }
}
