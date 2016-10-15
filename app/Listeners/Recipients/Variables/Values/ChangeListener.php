<?php

namespace App\Listeners\Recipients\Variables\Values;

use App\Models\Recipient\Variable\Value;

class ChangeListener
{
    /**
     * @var array
     */
    protected $map = [
        'first-name' => 'first_name',
        'last-name' => 'last_name',
        'timezone' => 'timezone',
        'locale' => 'locale',
        'gender' => 'gender',
    ];

    /**
     * @param Value $value
     */
    public function handle(Value $value)
    {
        $relation = $value->relation;

        if ($relation) {
            $variable = $relation->variable;
            $recipient = $relation->recipient;

            if ($variable && $recipient) {
                if ($value->isDirty('value')) {
                    if (isset($this->map[$variable->accessor])) {
                        $recipient->{$this->map[$variable->accessor]} = $value->value;
                        $recipient->save();
                    }
                }
            }
        }
    }
}
