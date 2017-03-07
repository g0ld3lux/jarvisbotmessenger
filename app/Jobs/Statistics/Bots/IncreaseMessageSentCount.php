<?php

namespace App\Jobs\Statistics\Bots;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IncreaseMessageSentCount extends IncreaseJob
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Return statistic key.
     *
     * @return string
     */
    protected function statisticKey()
    {
        return 'mass_messages_sent';
    }
}
