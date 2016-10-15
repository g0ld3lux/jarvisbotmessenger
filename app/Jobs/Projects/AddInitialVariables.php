<?php

namespace App\Jobs\Projects;

use App\Jobs\Job;
use App\Models\Project;
use App\Models\Recipient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddInitialVariables extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var array
     */
    protected $variables = [
        ['name' => 'First name', 'accessor' => 'first-name', 'type' => 'text'],
        ['name' => 'Last name', 'accessor' => 'last-name', 'type' => 'text'],
        ['name' => 'Gender', 'accessor' => 'gender', 'type' => 'text'],
        ['name' => 'Timezone', 'accessor' => 'timezone', 'type' => 'text'],
        ['name' => 'Locale', 'accessor' => 'locale', 'type' => 'text'],
    ];

    /**
     * @var Project
     */
    protected $project;

    /**
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Fetch user image.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->variables as $variable) {
            try {
                if ($this->project->recipientsVariables()->where('accessor', $variable['accessor'])->count() <= 0) {
                    $this->project->recipientsVariables()->save(new Recipient\Variable($variable));
                }
            } catch (\Exception $e) {
                logger($e);
            }
        }
    }
}
