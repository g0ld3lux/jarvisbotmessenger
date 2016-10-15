<?php

namespace App\Jobs\Recipients\Chat;

use App\Models\Recipient;

abstract class Job extends \App\Jobs\Job
{
    /**
     * @var Recipient
     */
    protected $recipient;

    /**
     * Job constructor.
     * @param Recipient $recipient
     */
    public function __construct(Recipient $recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @return boolean
     */
    abstract protected function enabled();

    /**
     * @return bool
     */
    public function handle()
    {
        $this->recipient->chat_disabled = !$this->enabled();
        $this->recipient->save();

        return true;
    }
}
