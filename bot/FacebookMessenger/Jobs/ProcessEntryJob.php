<?php

namespace Bot\FacebookMessenger\Jobs;

use Carbon\Carbon;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use DB;

class ProcessEntryJob extends Job
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var mixed
     */
    protected $pageId;

    /**
     * @var int
     */
    protected $time;

    /**
     * @var array
     */
    protected $messages;

    /**
     * ProcessEntryJob constructor.
     * @param mixed $pageId
     * @param int $time
     * @param array $messages
     */
    public function __construct($pageId, $time, array $messages)
    {
        $this->pageId = $pageId;
        $this->time = $time;
        $this->messages = $messages;
    }

    /**
     * @param Dispatcher $dispatcher
     */
    public function handle(Dispatcher $dispatcher)
    {
        if (is_null($this->pageId) || count($this->messages) <= 0) {
            return;
        }

        foreach ($this->messages as $message) {
            if ((bool) array_get($message, 'message.is_echo', false)) {
                continue;
            }

            if (array_has($message, 'delivery')) {
                continue;
            }

            if (array_has($message, 'read')) {
                continue;
            }

            if (array_has($message, 'message.mid')) {
                if ($this->isMessageProcessed(array_get($message, 'message.mid'))) {
                    continue;
                }

                $this->logProcessedMessage(array_get($message, 'message.mid'));
            }

            if (isset($message['message']) && isset($message['message']['quick_reply'])) {
                $dispatcher->dispatch($this->quickReplyJob($message));
            } elseif (isset($message['message'])) {
                $dispatcher->dispatch($this->messageJob($message));
            } elseif (isset($message['postback'])) {
                $dispatcher->dispatch($this->postbackJob($message));
            }
        }
    }

    /**
     * @param array $message
     * @return ProcessMessageJob
     */
    protected function quickReplyJob(array $message)
    {
        return new ProcessQuickReplyJob(
            array_get($message, 'sender.id'),
            array_get($message, 'recipient.id'),
            array_get($message, 'timestamp'),
            (array) array_get($message, 'message', [])
        );
    }

    /**
     * @param array $message
     * @return ProcessMessageJob
     */
    protected function messageJob(array $message)
    {
        return new ProcessMessageJob(
            array_get($message, 'sender.id'),
            array_get($message, 'recipient.id'),
            array_get($message, 'timestamp'),
            (array) array_get($message, 'message', [])
        );
    }

    /**
     * @param array $message
     * @return ProcessPostbackJob
     */
    protected function postbackJob(array $message)
    {
        if (Str::startsWith(array_get((array) $message, 'postback.payload'), '$$GETSTARTED$$')) {
            return new ProcessGetStartedJob(
                array_get($message, 'sender.id'),
                array_get($message, 'recipient.id'),
                array_get($message, 'timestamp'),
                (array) array_get($message, 'postback', [])
            );
        }

        return new ProcessPostbackJob(
            array_get($message, 'sender.id'),
            array_get($message, 'recipient.id'),
            array_get($message, 'timestamp'),
            (array) array_get($message, 'postback', [])
        );
    }

    /**
     * @param $mid
     * @return bool
     */
    protected function isMessageProcessed($mid)
    {
        return DB::table('incoming_messages')->where('mid', $mid)->count() > 0 ? true : false;
    }

    /**
     * @param $mid
     */
    protected function logProcessedMessage($mid)
    {
        try {
            DB::table('incoming_messages')->insert([
                'mid' => $mid,
                'created_at' => new Carbon(),
            ]);
        } catch (\Exception $e) {
            logger($e);
        }
    }
}
