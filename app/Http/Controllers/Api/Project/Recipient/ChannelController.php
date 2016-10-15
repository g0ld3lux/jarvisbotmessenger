<?php

namespace App\Http\Controllers\Api\Project\Recipient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\Recipient\Channel\StoreRequest;
use App\Models\Project;
use App\Models\Recipient;
use App\Models\Subscription\Channel;
use Datatables;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    /**
     * @param Request $request
     * @param Project $project
     * @param Recipient $recipient
     * @return mixed
     */
    public function index(Request $request, Project $project, Recipient $recipient)
    {
        $this->authorize('view', [$recipient, $project]);

        if ($request->get('all', false)) {
            return $recipient->subscriptionsChannels()->get();
        }

        return Datatables::of($recipient->subscriptionsChannels())->make(true);
    }

    /**
     * @param Project $project
     * @param Recipient $recipient
     * @param Channel $channel
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Project $project, Recipient $recipient, Channel $channel)
    {
        $this->authorize('view', [$recipient, $project]);

        $recipient->subscriptionsChannels()->detach($channel->id);

        return response()->json(['success' => true]);
    }

    /**
     * @param StoreRequest $request
     * @param Project $project
     * @param Recipient $recipient
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function store(StoreRequest $request, Project $project, Recipient $recipient)
    {
        $this->authorize('view', [$recipient, $project]);

        foreach ((array) $request->get('channels', []) as $channel) {
            $recipient->subscriptionsChannels()->attach($channel['id'], ['type' => $channel['type']]);
        }

        return $recipient->subscriptionsChannels()->get();
    }
}
