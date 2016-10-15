<?php

namespace App\Listeners\Recipients;

use App\Jobs\Recipients\AssignVariablesJob;
use App\Models\Recipient;
use Illuminate\Contracts\Bus\Dispatcher;

class ChangeListener
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * @var array
     */
    protected $map = [
        'first_name' => 'first-name',
        'last_name' => 'last-name',
        'timezone' => 'timezone',
        'locale' => 'locale',
        'gender' => 'gender',
    ];

    /**
     * NameListener constructor.
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Recipient $recipient
     */
    public function handle(Recipient $recipient)
    {
        $variables = [];

        foreach ($this->map as $key => $variable) {
            if ($recipient->isDirty($key)) {
                $variables[$variable] = $recipient->{$key};
            }
        }

        $this->dispatcher->dispatchNow(new AssignVariablesJob($recipient, $variables));
    }
}
