<?php

namespace App\Jobs\Recipients\AssignVariables;

use App\Jobs\Job;
use App\Models\Recipient;
use App\Models\Respond\Taxonomy;
use Illuminate\Support\Str;

class AssignTextVariablesJob extends Job
{
    /**
     * @var Recipient
     */
    protected $recipient;

    /**
     * @var Recipient\Variable
     */
    protected $variable;

    /**
     * @var array
     */
    protected $value;

    /**
     * @param Recipient $recipient
     * @param Recipient\Variable $variable
     * @param array $value
     */
    public function __construct(Recipient $recipient, Recipient\Variable $variable, $value)
    {
        $this->recipient = $recipient;
        $this->variable = $variable;
        $this->value = $value;
    }

    /**
     * @return void
     */
    public function handle()
    {
        $relation = $this->recipient->variables()->ofVariable($this->variable->id)->first();

        if (!$relation) {
            $relation = new Recipient\Variable\Relation();
            $relation->recipient_variable_id = $this->variable->id;
            $relation->recipient_id = $this->recipient->id;
            $relation->save();
        }

        $value = $relation->values()->ofKey('text')->first();

        if (Str::length($this->value) > 0) {
            if ($value) {
                $value->value = $this->value;
            } else {
                $value = new Recipient\Variable\Value(['key' => 'text', 'value' => $this->value, 'order' => 0]);
            }
            $value->relation_id = $relation->id;
            $value->save();
        } elseif ($value) {
            $value->delete();
        }

        if ($relation->values()->count() <= 0) {
            $relation->delete();
        }
    }
}
