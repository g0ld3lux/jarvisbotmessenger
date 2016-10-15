<?php

namespace App\Http\Controllers\Api\Project\Message;

use App\Http\Controllers\Controller;
use App\Models\Mass\Message;
use App\Models\Project;
use Datatables;

class ScheduleController extends Controller
{
    /**
     * @param Project $project
     * @param Message $message
     * @return mixed
     */
    public function index(Project $project, Message $message)
    {
        $this->authorize('view', [$message, $project]);

        return Datatables::of(
            Message\Schedule::with('recipient')->where('mass_message_id', $message->id)
        )->make(true);
    }
}
