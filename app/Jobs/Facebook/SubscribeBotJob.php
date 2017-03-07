<?php

namespace App\Jobs\Facebook;

use App\Jobs\Job;
use App\Models\Bot;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SubscribeBotJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var string
     */
    protected $url = 'https://graph.facebook.com/v2.6/me/subscribed_apps?access_token={token}';

    /**
     * @var Bot
     */
    protected $bot;

    /**
     * SubscribeBotJob constructor.
     * @param Bot $bot
     */
    public function __construct(Bot $bot)
    {
        $this->bot = $bot;
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
                $client->post(str_replace('{token}', $this->bot->page_token, $this->url))->getBody()->getContents()
            );

            if (isset($response->success) && $response->success) {
                $status = true;
            }
        } catch (\Exception $e) {
        }

        $this->bot->app_subscribed = $status;
        $this->bot->save();

        return $this->bot->app_subscribed;
    }
}
