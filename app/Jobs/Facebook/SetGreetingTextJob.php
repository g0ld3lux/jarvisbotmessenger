<?php

namespace App\Jobs\Facebook;

use App\Jobs\Job;
use App\Models\Bot;
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
     * @var Bot
     */
    protected $bot;

    /**
     * @var string
     */
    protected $text;

    /**
     * SubscribeBotJob constructor.
     * @param Bot $bot
     * @param $text
     */
    public function __construct(Bot $bot, $text)
    {
        $this->bot = $bot;
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
        return str_replace('{token}', $this->bot->page_token, $this->url);
    }
}
