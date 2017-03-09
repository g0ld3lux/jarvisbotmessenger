<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConnectPageRequest;
use App\Http\Requests\CreateBotRequest;
use App\Http\Requests\DeleteBotRequest;
use App\Http\Requests\UpdateBotDashboardRequest;
use App\Http\Requests\UpdateBotRequest;
use App\Http\Requests\UpdateBotThreadSettingsRequest;
use App\Jobs\Facebook\FetchLongLivedTokenJob;
use App\Jobs\Facebook\FetchUserPagesJobs;
use App\Jobs\Facebook\SubscribeBotJob;
use App\Models\Flow;
use App\Models\Bot;
use App\Models\Communication;
use App\Models\Respond;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;
use Notification;
use Socialite;

class BotsController extends Controller
{

    /**
     * Add a Middleware to Trigger when New User Sign Up!
     *
     */
    public function __construct()
    {
        $this->middleware('setup_wizard.trigger', ['only' => 'index']);
    }
    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bots = Bot::where('user_id', $request->user()->id)->orderBy('title', 'asc')->get();

        return view('bots.index', [
            'bots' => $bots,
        ]);
    }

    /**
     * Show new bot form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('bots.create');
    }

    /**
     * Store new bot to database.
     *
     * @param CreateBotRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateBotRequest $request)
    {
        $bot = new Bot([
            'title' => $request->get('title'),
            'timezone' => $request->get('timezone'),
        ]);

        $bot->user()->associate($request->user());

        $bot->save();

        Notification::success('Bot created successfully.');

        return redirect()->route('bots.show', $bot->id);
    }

    /**
     * Show bot dashboard.
     *
     * @param Bot $bot
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Bot $bot)
    {
        $this->authorize('view', $bot);

        if (!$bot->threadSettings) {
            $bot->threadSettings()->save(new Bot\Settings\Thread());
        }

        return view('bots.show', [
            'bot' => $bot,
        ]);
    }

    /**
     * Show bot settings.
     *
     * @param Bot $bot
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings(Bot $bot)
    {
        $this->authorize('settings', $bot);

        $responds = Respond::select('responds.*')
            ->leftJoin('responds_taxonomies', 'responds_taxonomies.respond_id', '=', 'responds.id')
            ->whereNull('responds.label')
            ->where('responds.bot_id', $bot->id)
            ->where('responds_taxonomies.type', 'buttons')
            ->whereNull('responds_taxonomies.parent_id')
            ->where(
                \DB::raw(
                    '(
                        select count(responds_taxonomies.id)
                        from responds_taxonomies
                        where responds_taxonomies.respond_id = responds.id
                        and responds_taxonomies.parent_id is null
                    )'
                ),
                1
            )
            ->get();

        return view('bots.settings', [
            'bot' => $bot,
            'responds' => $bot->responds()->global()->get(),
            'persistent_menu_responds' => $responds,
        ]);
    }

    /**
     * Update bot settings.
     *
     * @param UpdateBotRequest $request
     * @param Bot $bot
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateBotRequest $request, Bot $bot)
    {
        $this->authorize('settings', $bot);

        $bot->fill([
            'title' => $request->get('title'),
            'timezone' => $request->get('timezone'),
        ]);

        $bot->save();

        Notification::success('Bot updated successfully.');

        return redirect()->route('bots.settings', $bot->id);
    }

    /**
     * Update bot settings.
     *
     * @param UpdateBotDashboardRequest $request
     * @param Bot $bot
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDashboard(UpdateBotDashboardRequest $request, Bot $bot)
    {
        $this->authorize('settings', $bot);

        $bot->fill([
            'dashboard_active' => (bool) $request->get('dashboard_active'),
        ]);

        $bot->save();

        $message = $bot->dashboard_active ? 'enabled' : 'disabled';

        Notification::success('Bot dashboard '.$message.' successfully.');

        return redirect()->route('bots.settings', $bot->id)->withInput(['tab' => 'dashboard']);
    }

    /**
     * @param UpdateBotThreadSettingsRequest $request
     * @param Bot $bot
     * @return $this
     */
    public function updateThread(UpdateBotThreadSettingsRequest $request, Bot $bot)
    {
        $this->authorize('settings', $bot);

        $settings = $bot->threadSettings;

        $settings->fill([
            'greeting_text' => $request->get('greeting_text'),
        ]);

        try {
            $settings->getStartedRespond()->associate(
                $bot->responds()->findOrFail($request->get('get_started_respond_id'))
            );
        } catch (\Exception $e) {
            $settings->get_started_respond_id = null;
        }

        try {
            $settings->persistentMenuRespond()->associate(
                $bot->responds()->findOrFail($request->get('persistent_menu_respond_id'))
            );
        } catch (\Exception $e) {
            $settings->persistent_menu_respond_id = null;
        }

        $settings->save();

        Notification::success('Bot thread settings updated successfully.');

        return redirect()->route('bots.settings', $bot->id)->withInput(['tab' => 'thread']);
    }

    /**
     * Delete bot.
     *
     * @param DeleteBotRequest $request
     * @param Bot $bot
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(DeleteBotRequest $request, Bot $bot)
    {
        $this->authorize('delete', $bot);

        $bot->delete();

        Notification::success('Bot deleted successfully.');

        return redirect()->route('home');
    }
}
