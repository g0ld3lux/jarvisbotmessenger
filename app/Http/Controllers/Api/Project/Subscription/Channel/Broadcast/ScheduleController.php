<?php

namespace App\Http\Controllers\Api\Project\Subscription\Channel\Broadcast;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Subscription\Channel;
use Datatables;

class ScheduleController extends Controller
{
    /**
     * @param Project $project
     * @param Channel $channel
     * @param Channel\Broadcast $broadcast
     * @return mixed
     */
    public function index(Project $project, Channel $channel, Channel\Broadcast $broadcast)
    {
        $this->authorize('view', [$broadcast, $channel, $project]);

        return Datatables::of(
            Channel\Broadcast\Schedule::with('recipient')->where('broadcast_id', $broadcast->id)
        )->make(true);
    }
}
