<?php

namespace Plugins\TaxonomySubscribe\Jobs\Executable;

use App\Jobs\Recipients\AssignVariablesJob;
use App\Jobs\Subscription\Channel\AddSubscriberJob;
use App\Jobs\Subscription\Channel\RemoveSubscriberJob;
use App\Models\Bot;
use App\Models\Recipient;
use Bot\Core\Jobs\Job;
use Illuminate\Contracts\Bus\Dispatcher;

class SubscribeJob extends Job
{
    /**
     * @var string
     */
    protected $channel;

    /**
     * @var string
     */
    protected $option;

    /**
     * @var string
     */
    protected $bot;

    /**
     * @var Recipient
     */
    protected $recipient;

    /**
     * SaveInputJob constructor.
     * @param string $channel
     * @param string $option
     * @param Bot $bot
     * @param Recipient $recipient
     */
    public function __construct($channel, $option, Bot $bot, Recipient $recipient)
    {
        $this->channel = $channel;
        $this->option = $option;
        $this->bot = $bot;
        $this->recipient = $recipient;
    }

    /**
     * @param Dispatcher $dispatcher
     */
    public function handle(Dispatcher $dispatcher)
    {
        $channel = $this->bot->subscriptionsChannels()->findOrFail($this->channel);

        if ($this->option == 'add') {
            $dispatcher->dispatchNow(new AddSubscriberJob($channel, $this->recipient));
        } elseif ($this->option == 'remove') {
            $dispatcher->dispatchNow(new RemoveSubscriberJob($channel, $this->recipient));
        }
    }
}
