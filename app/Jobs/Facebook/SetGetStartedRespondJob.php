<?php

namespace App\Jobs\Facebook;

use App\Jobs\Job;
use App\Models\Bot;
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
     * @var Bot
     */
    protected $bot;

    /**
     * @var Respond
     */
    protected $respond;

    /**
     * SubscribeBotJob constructor.
     * @param Bot $bot
     * @param Respond $respond
     */
    public function __construct(Bot $bot, Respond $respond)
    {
        $this->bot = $bot;
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
        return str_replace('{token}', $this->bot->page_token, $this->url);
    }
}
