<?php

namespace App\Jobs\Facebook;

use App\Jobs\Job;
use App\Models\Project;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SubscribeProjectJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var string
     */
    protected $url = 'https://graph.facebook.com/v2.6/me/subscribed_apps?access_token={token}';

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
     * @return boolean
     */
    public function handle()
    {
        $client = new Client();

        $status = false;

        try {
            $response = json_decode(
                $client->post(str_replace('{token}', $this->project->page_token, $this->url))->getBody()->getContents()
            );

            if (isset($response->success) && $response->success) {
                $status = true;
            }
        } catch (\Exception $e) {
        }

        $this->project->app_subscribed = $status;
        $this->project->save();

        return $this->project->app_subscribed;
    }
}
