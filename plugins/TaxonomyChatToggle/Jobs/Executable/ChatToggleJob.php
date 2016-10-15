<?php

namespace Plugins\TaxonomyChatToggle\Jobs\Executable;

use App\Models\Recipient;
use Bot\Core\Jobs\Job;

class ChatToggleJob extends Job
{
    /**
     * @var string
     */
    protected $option;

    /**
     * @var Recipient
     */
    protected $recipient;

    /**
     * @param string $option
     * @param Recipient $recipient
     */
    public function __construct($option, Recipient $recipient)
    {
        $this->option = $option;
        $this->recipient = $recipient;
    }

    /**
     * Send message.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->option == 'enable' && $this->recipient->chat_disabled) {
            $this->recipient->chat_disabled = false;
            $this->recipient->save();
        } elseif ($this->option == 'disable' && !$this->recipient->chat_disabled) {
            $this->recipient->chat_disabled = true;
            $this->recipient->save();
        }
    }
}
