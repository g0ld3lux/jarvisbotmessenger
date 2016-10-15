<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\Message\StoreRequest;
use App\Jobs\Mass\Message\ScheduleJob;
use App\Models\Mass\Message;
use App\Models\Project;
use Carbon\Carbon;
use Datatables;
use Illuminate\Contracts\Bus\Dispatcher;

class MessageController extends Controller
{
    /**
     * @param Project $project
     * @return mixed
     */
    public function index(Project $project)
    {
        $this->authorize('view', $project);

        return Datatables::of($project->massMessages())->make(true);
    }

    /**
     * @param StoreRequest $request
     * @param Dispatcher $dispatcher
     * @param Project $project
     * @return Message
     */
    public function store(StoreRequest $request, Dispatcher $dispatcher, Project $project)
    {
        $this->authorize('view', $project);

        $currentTZ = date_default_timezone_get();

        date_default_timezone_set($project->timezone);

        $scheduledAt = new Carbon($request->get('scheduled_at'));
        $scheduledAt->setTimezone($currentTZ);

        date_default_timezone_set($currentTZ);

        $message = new Message([
            'name' => $request->get('name'),
            'scheduled_at' => new Carbon($scheduledAt),
        ]);

        $message->project()->associate($project);

        $message->save();

        $message->responds()->sync((array) $request->get('responds', []));

        $dispatcher->dispatchNow(new ScheduleJob(
            $message,
            count((array) $request->get('recipients', [])) > 0
            ? $project->recipients()->whereIn('id', $request->get('recipients'))->get()->all()
            : [],
            (int) $request->get('interval', 0),
            $request->get('timezone')
        ));

        return $message;
    }

    /**
     * @param Project $project
     * @param Message $message
     * @return Message
     */
    public function show(Project $project, Message $message)
    {
        $this->authorize('view', [$message, $project]);

        $message->load('responds');

        return $message;
    }

    /**
     * @param Project $project
     * @param Message $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project, Message $message)
    {
        $this->authorize('delete', [$message, $project]);

        $message->delete();

        return response()->json(['success' => true]);
    }
}
