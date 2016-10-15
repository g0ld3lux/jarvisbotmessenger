<?php

namespace App\Http\Controllers\Api\Project\Subscription\Channel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\Subscription\Channel\Recipient\StoreRequest;
use App\Models\Project;
use App\Models\Recipient;
use App\Models\Subscription\Channel;
use Datatables;

class RecipientController extends Controller
{
    /**
     * @param Project $project
     * @param Channel $channel
     * @return mixed
     */
    public function index(Project $project, Channel $channel)
    {
        $this->authorize('view', [$channel, $project]);

        return Datatables::of(
            $channel
                ->recipients()
                ->select([
                    'recipients.*',
                    'subscriptions_channels_recipients.type as join_type',
                    'subscriptions_channels_recipients.created_at as joined_at',
                    'subscriptions_channels_recipients.channel_id as channel_id',
                ])
        )->make(true);
    }

    /**
     * @param Project $project
     * @param Channel $channel
     * @return mixed
     */
    public function missingRecipients(Project $project, Channel $channel)
    {
        $this->authorize('view', [$channel, $project]);

        return Datatables::of(
            Recipient::select('recipients.*')
                ->where('recipients.project_id', $project->id)
                ->whereNotExists(function ($query) use ($channel) {
                    $query
                        ->select('subscriptions_channels_recipients.*')
                        ->from('subscriptions_channels_recipients')
                        ->where('subscriptions_channels_recipients.channel_id', $channel->id)
                        ->where('recipients.id', \DB::raw('subscriptions_channels_recipients.recipient_id'));
                })
        )->make(true);
    }

    /**
     * @param Project $project
     * @param Channel $channel
     * @param Recipient $recipient
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Project $project, Channel $channel, Recipient $recipient)
    {
        $this->authorize('view', [$channel, $project]);

        $channel->recipients()->detach($recipient->id);

        return response()->json(['success' => true]);
    }

    /**
     * @param StoreRequest $request
     * @param Project $project
     * @param Channel $channel
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function store(StoreRequest $request, Project $project, Channel $channel)
    {
        $this->authorize('view', [$channel, $project]);

        foreach ((array) $request->get('recipients', []) as $recipient) {
            $channel->recipients()->attach($recipient['id'], ['type' => $recipient['type']]);
        }

        return response()->json(['success' => true]);
    }
}
