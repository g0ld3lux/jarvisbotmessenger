<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners;
use App\Events;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'eloquent.created: App\Models\Recipient' => [
            Listeners\FetchRecipientDataListener::class,
        ],
        'eloquent.created: App\Models\Bot' => [
            Listeners\Bots\InitialVariablesListener::class,
            Listeners\Bots\BotCreatedListener::class,
        ],
        'eloquent.saved: App\Models\Recipient\Variable\Value' => [
            Listeners\Recipients\Variables\Values\ChangeListener::class,
        ],
        'eloquent.saved: App\Models\Recipient' => [
            Listeners\Recipients\ChangeListener::class,
        ],
        'eloquent.saved: App\Models\Bot' => [
            Listeners\Bots\PageTokenUpdatedListener::class,
        ],
        'eloquent.saved: App\Models\Bot\Settings\Thread' => [
            Listeners\Bots\Settings\Thread\GreetingText\SavedListener::class,
            Listeners\Bots\Settings\Thread\GetStartedRespond\SavedListener::class,
            Listeners\Bots\Settings\Thread\PersistentMenuRespond\SavedListener::class,
        ],
        Events\ScheduleProcessedEvent::class => [
            Listeners\IncreaseMessagesSentCountListener::class,
            Listeners\FinishMessageListener::class,
        ],
        Events\Subscription\Channel\SubscriberAddedEvent::class => [
            Listeners\Subscription\Channel\IncreaseSubscribersCountListener::class,
        ],
        Events\Subscription\Channel\SubscriberRemovedEvent::class => [
            Listeners\Subscription\Channel\DecreaseSubscribersCountListener::class,
        ],
        Events\Subscription\Channel\Broadcast\ScheduleProcessedEvent::class => [
            Listeners\Subscription\Channel\Broadcast\FinishBroadcastListener::class,
            Listeners\Subscription\Channel\Broadcast\IncreaseMessagesSentCountListener::class,
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        $events->listen(QueryExecuted::class, function (QueryExecuted $queryExecuted) {
            if (php_sapi_name() == 'cli') {
                \Storage::append('sql.sql', $queryExecuted->sql);
            }
        });
        //
    }
}
