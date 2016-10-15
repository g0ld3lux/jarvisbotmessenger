<?php

namespace Plugins\TaxonomySubscribe\Jobs\Executable;

use App\Jobs\Recipients\AssignVariablesJob;
use App\Jobs\Subscription\Channel\AddSubscriberJob;
use App\Jobs\Subscription\Channel\RemoveSubscriberJob;
use App\Models\Project;
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
    protected $project;

    /**
     * @var Recipient
     */
    protected $recipient;

    /**
     * SaveInputJob constructor.
     * @param string $channel
     * @param string $option
     * @param Project $project
     * @param Recipient $recipient
     */
    public function __construct($channel, $option, Project $project, Recipient $recipient)
    {
        $this->channel = $channel;
        $this->option = $option;
        $this->project = $project;
        $this->recipient = $recipient;
    }

    /**
     * @param Dispatcher $dispatcher
     */
    public function handle(Dispatcher $dispatcher)
    {
        $channel = $this->project->subscriptionsChannels()->findOrFail($this->channel);

        if ($this->option == 'add') {
            $dispatcher->dispatchNow(new AddSubscriberJob($channel, $this->recipient));
        } elseif ($this->option == 'remove') {
            $dispatcher->dispatchNow(new RemoveSubscriberJob($channel, $this->recipient));
        }
    }
}
