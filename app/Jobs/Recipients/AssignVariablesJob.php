<?php

namespace App\Jobs\Recipients;

use App\Jobs\Job;
use App\Models\Recipient;
use App\Models\Respond\Taxonomy;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Str;

class AssignVariablesJob extends Job
{
    /**
     * @var Recipient
     */
    protected $recipient;

    /**
     * @var array
     */
    protected $variables;

    /**
     * @param Recipient $recipient
     * @param array $variables
     */
    public function __construct(Recipient $recipient, array $variables = [])
    {
        $this->recipient = $recipient;
        $this->variables = $variables;
    }

    /**
     * @param Dispatcher $dispatcher
     */
    public function handle(Dispatcher $dispatcher)
    {
        foreach ($this->variables as $variable => $value) {
            $model = Recipient\Variable::where('project_id', $this->recipient->project_id)
                ->where('accessor', $variable)
                ->first();

            if ($model) {
                $class = 'App\Jobs\Recipients\AssignVariables\Assign'.Str::studly($model->type).'VariablesJob';

                if (class_exists($class)) {
                    $dispatcher->dispatchNow(new $class($this->recipient, $model, $value));
                }
            }
        }
    }
}
