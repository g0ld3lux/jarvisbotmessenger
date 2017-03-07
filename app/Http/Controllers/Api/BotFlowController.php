<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Flow\SortRequest;
use App\Http\Requests\Api\Flow\StoreRequest;
use App\Http\Requests\Api\Flow\UpdateRequest;
use App\Http\Requests\Api\Bot\Flow\ImportRequest;
use App\Models\Flow;
use App\Models\Bot;
use App\Services\Flow\Exchange;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Storage;

class BotFlowController extends Controller
{
    /**
     * Return bot flows.
     *
     * @param Bot $bot
     * @return Collection
     */
    public function index(Bot $bot)
    {
        $this->authorize('view', $bot);

        return Flow::with('responds', 'matchers', 'matchers.params')
            ->where('bot_id', $bot->id)
            ->ordered()
            ->get();
    }

    /**
     * Return single flow.
     *
     * @param Bot $bot
     * @param Flow $flow
     * @return Flow
     */
    public function show(Bot $bot, Flow $flow)
    {
        $this->authorize('view', $bot);

        $flow->load(['responds', 'matchers', 'matchers.params']);

        return $flow;
    }

    /**
     * Store new flow.
     *
     * @param StoreRequest $request
     * @param Bot $bot
     * @return Flow
     */
    public function store(StoreRequest $request, Bot $bot)
    {
        $this->authorize('view', $bot);

        $flow = new Flow([
            'title' => $request->get('title'),
            'order' => $bot->flows()->max('order') + 1,
        ]);
        $flow->bot()->associate($bot);
        $flow->save();

        $flow->responds()->sync(array_pluck((array) $request->get('responds', []), 'id'));

        return $flow;
    }

    /**
     * Update existing flow.
     *
     * @param UpdateRequest $request
     * @param Bot $bot
     * @param Flow $flow
     * @return Flow
     */
    public function update(UpdateRequest $request, Bot $bot, Flow $flow)
    {
        $this->authorize('edit', [$flow, $bot]);

        $flow->fill(['title' => $request->get('title')]);
        $flow->save();

        $flow->responds()->sync(array_pluck((array) $request->get('responds', []), 'id'));

        return $flow;
    }

    /**
     * Delete given flow.
     *
     * @param Bot $bot
     * @param Flow $flow
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Bot $bot, Flow $flow)
    {
        $this->authorize('delete', [$flow, $bot]);

        $flow->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Make flow as default.
     *
     * @param Bot $bot
     * @param Flow $flow
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeDefault(Bot $bot, Flow $flow)
    {
        $this->authorize('view', [$flow, $bot]);

        $bot->flows()->update(['defaulted_at' => null]);
        $flow->defaulted_at = new Carbon();
        $flow->save();

        return response()->json(['success' => true]);
    }

    /**
     * Delete default flow.
     *
     * @param Bot $bot
     * @param Flow $flow
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDefault(Bot $bot, Flow $flow)
    {
        $this->authorize('view', [$flow, $bot]);

        $flow->defaulted_at = null;
        $flow->save();

        return response()->json(['success' => true]);
    }

    /**
     * Update positions.
     *
     * @param SortRequest $request
     * @param Bot $bot
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSort(SortRequest $request, Bot $bot)
    {
        $this->authorize('view', $bot);

        foreach ($request->get('sort') as $sort) {
            $bot->flows()->where('id', $sort['flow'])->update(['order' => $sort['position']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * @param Request $request
     * @param Bot $bot
     * @param Exchange $exchange
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request, Bot $bot, Exchange $exchange)
    {
        $this->authorize('view', $bot);

        if (count((array) $request->get('flows', [])) > 0) {
            $flows = $bot->flows()->whereIn('id', (array) $request->get('flows', []))->ordered()->get();
        } else {
            $flows = $bot->flows()->ordered()->get();
        }

        $file = 'public/export/bot_'.$bot->id.'.json';

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
     * @param Bot $bot
     * @param Exchange $exchange
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(ImportRequest $request, Bot $bot, Exchange $exchange)
    {
        $this->authorize('view', $bot);

        try {
            $data = json_decode(Storage::get('public/import/bot_'.$bot->id.'.json'));

            if ($exchange->import($bot, $data, $data->meta->version)) {
                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
            logger($e);
        }

        return response()->json(['success' => false], 422);
    }
}
