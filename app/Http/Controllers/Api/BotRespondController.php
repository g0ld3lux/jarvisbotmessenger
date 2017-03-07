<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bot;
use App\Models\Respond;
use Illuminate\Database\Eloquent\Collection;

class BotRespondController extends Controller
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

        return $bot->responds()->orderBy('title', 'asc')->global()->get();
    }

    /**
     * @param Bot $bot
     * @param Respond $respond
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Bot $bot, Respond $respond)
    {
        $this->authorize('delete', [$respond, $bot]);

        $respond->delete();

        return response()->json(['success' => true]);
    }
}
