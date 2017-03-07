<?php

namespace App\Http\Controllers;

use App\Http\Requests\Respond\UpdateRequest;
use App\Models\Bot;
use App\Models\Respond;
use Carbon\Carbon;
use Notification;

class RespondsController extends Controller
{
    /**
     * @param Bot $bot
     * @return \Illuminate\Http\Response
     */
    public function index(Bot $bot)
    {
        $this->authorize('view', $bot);

        return view('bots.responds.index', ['bot' => $bot]);
    }

    /**
     * Show new link form.
     *
     * @param Bot $bot
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Bot $bot)
    {
        $this->authorize('view', $bot);

        $respond = new Respond([
            'title' => 'Draft v.'.adjust_bot_timezone($bot, new Carbon())->format('F j, Y, g:i A'),
        ]);
        $respond->bot()->associate($bot);
        $respond->save();

        return redirect()->route('bots.responds.edit', [$bot->id, $respond->id]);
    }

    /**
     * Edit matcher.
     *
     * @param Bot $bot
     * @param Respond $respond
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Bot $bot, Respond $respond)
    {
        $this->authorize('edit', [$respond, $bot]);

        return view('bots.responds.edit', [
            'bot' => $bot,
            'respond' => $respond,
            'taxonomies' => $respond->taxonomies()->ofRoot()->ordered()->get(),
        ]);
    }

    /**
     * Update matcher.
     *
     * @param UpdateRequest $request
     * @param Bot $bot
     * @param Respond $respond
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Bot $bot, Respond $respond)
    {
        $this->authorize('edit', [$respond, $bot]);

        $respond->fill(['title' => $request->get('title')]);

        $respond->save();

        Notification::success('Respond updated successfully.');

        return redirect()->route('bots.responds.edit', [$bot->id, $respond->id]);
    }

    /**
     * Delete link.
     *
     * @param Bot $bot
     * @param Respond $respond
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Bot $bot, Respond $respond)
    {
        $this->authorize('delete', [$respond, $bot]);

        $respond->delete();

        Notification::success('Respond deleted successfully.');

        return redirect()->route('bots.responds.index', $bot->id);
    }
}
