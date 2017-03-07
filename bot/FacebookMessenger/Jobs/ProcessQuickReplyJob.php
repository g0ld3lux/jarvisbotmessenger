<?php

namespace Bot\FacebookMessenger\Jobs;

use App\Models\Bot;
use App\Models\Recipient;
use App\Services\QuickReplyMatcher;
use App\Services\RecipientProvider;
use Bot\Core\Contract\Executable;
use Bot\Core\Executor;
use Bot\FacebookMessenger\Bots;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Communication;
use Plugins\TaxonomyChatToggle\Executable\ChatToggle;

class ProcessQuickReplyJob extends Job
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
    protected $quickReply;

    /**
     * ProcessMessageJob constructor.
     * @param mixed $senderId
     * @param mixed $recipientId
     * @param int $timestamp
     * @param array $quickReply
     */
    public function __construct($senderId, $recipientId, $timestamp, array $quickReply)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->timestamp = $timestamp;
        $this->quickReply = $quickReply;
    }

    /**
     * @param QuickReplyMatcher $matcher
     * @param Mapper $mapper
     * @param Bots $bots
     * @param RecipientProvider $recipientProvider
     * @param Executor $executor
     */
    public function handle(
        QuickReplyMatcher $matcher,
        Mapper $mapper,
        Bots $bots,
        RecipientProvider $recipientProvider,
        Executor $executor
    ) {
        if (is_null($this->senderId)
            || is_null($this->recipientId)
            || !isset($this->quickReply['quick_reply']['payload'])) {
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

            if (!$this->shouldProcess($recipient, $messages)) {
                return;
            }

            foreach ($messages as $message) {
                $executor->execute(
                    'quickreply',
                    $this->message(),
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
    protected function message()
    {
        return array_get($this->quickReply, 'text');
    }

    /**
     * @return string
     */
    protected function payload()
    {
        return array_get($this->quickReply, 'quick_reply.payload');
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
