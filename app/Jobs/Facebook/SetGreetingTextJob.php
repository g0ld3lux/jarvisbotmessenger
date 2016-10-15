<?php

namespace App\Jobs\Facebook;

use App\Jobs\Job;
use App\Models\Project;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetGreetingTextJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var string
     */
    protected $url = 'https://graph.facebook.com/v2.6/me/thread_settings?access_token={token}';

    /**
     * @var Project
     */
    protected $project;

    /**
     * @var string
     */
    protected $text;

    /**
     * SubscribeProjectJob constructor.
     * @param Project $project
     * @param $text
     */
    public function __construct(Project $project, $text)
    {
        $this->project = $project;
        $this->text = $text;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function handle()
    {
        $client = new Client();

        $status = false;

        try {
            $client->post($this->url(), [
                'form_params' => [
                    'setting_type' => 'greeting',
                    'greeting' => [
                        'text' => $this->text,
                    ],
                ],
            ]);

            $status = true;
        } catch (\Exception $e) {
            logger($e);
        }

        return $status;
    }

    /**
     * @return string
     */
    protected function url()
    {
        return str_replace('{token}', $this->project->page_token, $this->url);
    }
}
