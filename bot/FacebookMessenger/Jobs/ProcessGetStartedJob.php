<?php

namespace Bot\FacebookMessenger\Jobs;

use App\Models\Bot;
use App\Models\Recipient;
use App\Services\GetStartedMatcher;
use App\Services\RecipientProvider;
use Bot\Core\Contract\Executable;
use Bot\Core\Executor;
use Bot\FacebookMessenger\Bots;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Communication;
use Plugins\TaxonomyChatToggle\Executable\ChatToggle;

class ProcessGetStartedJob extends Job
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
     * @param GetStartedMatcher $matcher
     * @param Mapper $mapper
     * @param Bots $bots
     * @param RecipientProvider $recipientProvider
     * @param Executor $executor
     */
    public function handle(
        GetStartedMatcher $matcher,
        Mapper $mapper,
        Bots $bots,
        RecipientProvider $recipientProvider,
        Executor $executor
    ) {
        if (is_null($this->senderId) || is_null($this->recipientId) || !isset($this->postback['payload'])) {
            return;
        }

        $payload = $this->payload();

        $bot = Bot::where('page_id', $this->recipientId)->first();

        if (is_null($bot)) {
            return;
        }

        $recipient = $recipientProvider->get($bot, $this->senderId);

        try {
            $responds = $matcher->match($bot, $recipient, $payload);

            $messages = [];

            foreach ($responds as $respond) {
                $messages = array_merge($messages, $mapper->mapRespond($respond, $this->senderId));
            }

            foreach ($messages as $message) {
                $executor->execute(
                    'getstarted',
                    $payload,
                    null,
                    $bot,
                    $recipient,
                    $message,
                    $bots->get($bot->page_token)
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
}
