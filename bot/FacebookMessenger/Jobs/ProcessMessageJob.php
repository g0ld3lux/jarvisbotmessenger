<?php

namespace Bot\FacebookMessenger\Jobs;

use App\Jobs\Statistics\Projects\IncreaseMissedRespondCount;
use App\Jobs\Statistics\Projects\IncreasePassedRespondCount;
use App\Models\Project;
use App\Models\Recipient;
use App\Services\RecipientProvider;
use App\Services\RespondMatcher;
use Bot\Core\Contract\Executable;
use Bot\Core\Executor;
use Bot\FacebookMessenger\Bots;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Communication;
use Plugins\TaxonomyChatToggle\Executable\ChatToggle;

class ProcessMessageJob extends Job
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var mixed
     */
    protected $senderId;

    /**
     * @var mixed
     */
    protected $recipientId;

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var array
     */
    protected $message;

    /**
     * ProcessMessageJob constructor.
     * @param mixed $senderId
     * @param mixed $recipientId
     * @param int $timestamp
     * @param array $message
     */
    public function __construct($senderId, $recipientId, $timestamp, array $message)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->timestamp = $timestamp;
        $this->message = $message;
    }

    /**
     * @param Dispatcher $dispatcher
     * @param RespondMatcher $matcher
     * @param Mapper $mapper
     * @param Bots $bots
     * @param RecipientProvider $recipientProvider
     * @param Executor $executor
     */
    public function handle(
        Dispatcher $dispatcher,
        RespondMatcher $matcher,
        Mapper $mapper,
        Bots $bots,
        RecipientProvider $recipientProvider,
        Executor $executor
    ) {
        if (is_null($this->senderId) || is_null($this->recipientId) || !isset($this->message['text'])) {
            return;
        }

        $text = $this->text();

        $project = Project::where('page_id', $this->recipientId)->first();

        if (is_null($project)) {
            return;
        }

        $communicationLog = new Communication\Log([
            'message' => $text,
        ]);

        $recipient = $recipientProvider->get($project, $this->senderId);

        $communicationLog->project()->associate($project);
        $communicationLog->recipient()->associate($recipient);

        try {
            $flow = $matcher->match($project, $recipient, $text);
            $communicationLog->flow()->associate($flow->getOriginal());

            $messages = $mapper->map($flow, $this->senderId);

            if (!$this->shouldProcess($recipient, $messages)) {
                return;
            }

            foreach ($messages as $message) {
                $executor->execute(
                    'message',
                    $text,
                    $flow,
                    $project,
                    $recipient,
                    $message,
                    $bots->get($project->page_token)
                );
            }

            $dispatcher->dispatch(new IncreasePassedRespondCount($project));
        } catch (\Exception $e) {
            logger($e);

            $dispatcher->dispatch(new IncreaseMissedRespondCount($project));
        }

        $communicationLog->save();
    }

    /**
     * @return string
     */
    protected function text()
    {
        return array_get($this->message, 'text');
    }

    /**
     * @param Recipient $recipient
     * @param Executable[] $messages
     * @return bool
     */
    protected function shouldProcess(Recipient $recipient, array $messages = [])
    {
        if (!$recipient->chat_disabled) {
            return true;
        }

        $process = false;

        foreach ($messages as $message) {
            if ($message instanceof ChatToggle) {
                $process = $message->getOption() == 'enable' ? true : false;
            }
        }

        return $process;
    }
}
