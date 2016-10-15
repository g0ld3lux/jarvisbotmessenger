<?php

namespace App\Console\Commands\Projects\Variables;

use App\Jobs\Projects\AddInitialVariables;
use App\Models\Project;
use App\Models\Recipient;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;
use Symfony\Component\Console\Input\InputOption;

class Initial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'projects:variables:initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add initial variables for a project';

    /**
     * @param Dispatcher $dispatcher
     */
    public function handle(Dispatcher $dispatcher)
    {
        $query = Project::select('*');

        if ($this->option('project-id')) {
            $query = $query->where('id', $this->option('project-id'));
        }

        $this->output->progressStart($query->count());

        $query->chunk(20, function ($projects) use ($dispatcher) {
            foreach ($projects as $project) {
                $dispatcher->dispatchNow(new AddInitialVariables($project));

                $this->output->progressAdvance(1);
            }
        });

        $this->output->progressFinish();

        $this->info('Done');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['project-id', null, InputOption::VALUE_OPTIONAL, 'Project ID'],
        ];
    }
}
