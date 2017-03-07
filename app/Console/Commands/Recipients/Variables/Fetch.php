<?php

namespace App\Console\Commands\Recipients\Variables;

use App\Jobs\DownloadRecipientPhoto;
use App\Jobs\Recipients\FetchRecipientDataJob;
use App\Models\Recipient;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;
use Symfony\Component\Console\Input\InputOption;

class Fetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'recipients:variables:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch user variables';

    /**
     * @param Dispatcher $dispatcher
     */
    public function handle(Dispatcher $dispatcher)
    {
        $query = Recipient::select('*');

        if ($this->option('bot-id')) {
            $query = $query->where('bot_id', $this->option('bot-id'));
        }

        if ($this->option('recipient-id')) {
            $query = $query->where('id', $this->option('recipient-id'));
        }

        $sleep = $this->option('sleep') ? $this->option('sleep') : false;

        $this->output->progressStart($query->count());

        $query->chunk(20, function ($recipients) use ($sleep, $dispatcher) {
            foreach ($recipients as $recipient) {
                $data = $dispatcher->dispatchNow(new FetchRecipientDataJob(
                    $recipient->reference,
                    $recipient->bot->page_token
                ));

                $recipient->fill([
                    'first_name' => array_get($data, 'first_name'),
                    'last_name' => array_get($data, 'last_name'),
                    'locale' => array_get($data, 'locale'),
                    'gender' => array_get($data, 'gender'),
                    'timezone' => timezone_gmt_name_from_offset(array_get($data, 'timezone')),
                    'photo' => array_get($data, 'profile_pic'),
                ]);

                $recipient->save();

                $dispatcher->dispatch(new DownloadRecipientPhoto($recipient));

                $this->output->progressAdvance(1);

                if ($sleep) {
                    sleep($sleep);
                }
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
            ['bot-id', null, InputOption::VALUE_OPTIONAL, 'Bot ID'],
            ['recipient-id', null, InputOption::VALUE_OPTIONAL, 'Recipient ID'],
            ['sleep', null, InputOption::VALUE_OPTIONAL, 'Sleep in seconds'],
        ];
    }
}
