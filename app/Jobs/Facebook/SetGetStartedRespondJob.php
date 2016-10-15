<?php

namespace App\Jobs\Facebook;

use App\Jobs\Job;
use App\Models\Project;
use App\Models\Respond;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetGetStartedRespondJob extends Job implements ShouldQueue
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
     * @var Respond
     */
    protected $respond;

    /**
     * SubscribeProjectJob constructor.
     * @param Project $project
     * @param Respond $respond
     */
    public function __construct(Project $project, Respond $respond)
    {
        $this->project = $project;
        $this->respond = $respond;
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
                    'setting_type' => 'call_to_actions',
                    'thread_state' => 'new_thread',
                    'call_to_actions' => [
                        [
                            'payload' => '$$GETSTARTED$$'.$this->respond->id,
                        ],
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
