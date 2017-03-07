<?php

namespace App\Services;

use App\Jobs\Statistics\Bots\IncreaseRecipientsCount;
use App\Models\Bot;
use App\Models\Recipient;
use Illuminate\Contracts\Bus\Dispatcher;

class RecipientProvider
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * RecipientProvider constructor.
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Get recipient.
     *
     * @param Bot $bot
     * @param $reference
     * @return \App\Models\Recipient
     */
    public function get(Bot $bot, $reference)
    {
        try {
            return $this->find($bot, $reference);
        } catch (\Exception $e) {
        }

        return $this->create($bot, $reference);
    }

    /**
     * Find recipient.
     *
     * @param Bot $bot
     * @param $reference
     * @return \App\Models\Recipient
     */
    protected function find(Bot $bot, $reference)
    {
        return Recipient::where('bot_id', $bot->id)->where('reference', $reference)->firstOrFail();
    }

    /**
     * Create new recipient.
     *
     * @param Bot $bot
     * @param $reference
     * @return \App\Models\Recipient
     */
    protected function create(Bot $bot, $reference)
    {
        $recipient = new Recipient(['reference' => $reference]);
        $recipient->bot()->associate($bot);
        $recipient->save();

        $this->dispatcher->dispatch(new IncreaseRecipientsCount($bot));

        return $recipient;
    }
}
