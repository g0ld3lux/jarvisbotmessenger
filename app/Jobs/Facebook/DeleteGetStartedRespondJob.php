<?php

namespace App\Jobs\Facebook;

use App\Jobs\Job;
use App\Models\Project;
use App\Models\Respond;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteGetStartedRespondJob extends Job implements ShouldQueue
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
     * SubscribeProjectJob constructor.
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
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
            $client->delete($this->url(), [
                'form_params' => [
                    'setting_type' => 'call_to_actions',
                    'thread_state' => 'new_thread',
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
