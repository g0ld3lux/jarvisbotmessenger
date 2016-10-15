<?php

namespace Bot\FacebookMessenger\Jobs;

use App\Models\Project;
use App\Models\Recipient;
use App\Services\PostbackMatcher;
use App\Services\RecipientProvider;
use Bot\Core\Contract\Executable;
use Bot\Core\Executor;
use Bot\FacebookMessenger\Bots;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Communication;
use Plugins\TaxonomyChatToggle\Executable\ChatToggle;

class ProcessPostbackJob extends Job
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
    protected $postback;

    /**
     * ProcessMessageJob constructor.
     * @param mixed $senderId
     * @param mixed $recipientId
     * @param int $timestamp
     * @param array $postback
     */
    public function __construct($senderId, $recipientId, $timestamp, array $postback)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->timestamp = $timestamp;
        $this->postback = $postback;
    }

    /**
     * @param PostbackMatcher $matcher
     * @param Mapper $mapper
     * @param Bots $bots
     * @param RecipientProvider $recipientProvider
     * @param Executor $executor
     */
    public function handle(
        PostbackMatcher $matcher,
        Mapper $mapper,
        Bots $bots,
        RecipientProvider $recipientProvider,
        Executor $executor
    ) {
        if (is_null($this->senderId) || is_null($this->recipientId) || !isset($this->postback['payload'])) {
            return;
        }

        $payload = $this->payload();

        $project = Project::where('page_id', $this->recipientId)->first();

        if (is_null($project)) {
            return;
        }

        $recipient = $recipientProvider->get($project, $this->senderId);

        try {
            $responds = $matcher->match($project, $recipient, $payload);

            $messages = [];

            foreach ($responds as $respond) {
                $messages = array_merge($messages, $mapper->mapRespond($respond, $this->senderId));
            }

            if (!$this->shouldProcess($recipient, $messages)) {
                return;
            }

            foreach ($messages as $message) {
                $executor->execute(
                    'postback',
                    $payload,
                    null,
                    $project,
                    $recipient,
                    $message,
                    $bots->get($project->page_token)
                );
            }
        } catch (\Exception $e) {
            logger($e);
        }
    }

    /**
     * @return string
     */
    protected function payload()
    {
        return array_get($this->postback, 'payload');
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
