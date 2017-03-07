<?php

namespace App\Jobs\Facebook;

use App\Jobs\Job;
use App\Models\Bot;
use App\Models\Recipient;
use App\Models\Respond;
use App\Services\RespondMatcher;
use Bot\FacebookMessenger\Executable\Message;
use Bot\FacebookMessenger\Mapper;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use pimax\Messages\MessageButton;
use pimax\Messages\StructuredMessage;

class SetPersistentMenuRespondJob extends Job implements ShouldQueue
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
     * @param RespondMatcher $matcher
     * @param Mapper $mapper
     * @return bool
     * @throws \Exception
     */
    public function handle(RespondMatcher $matcher, Mapper $mapper)
    {
        $respond = $matcher->respond($this->respond, new Recipient());

        $mapped = $mapper->mapRespond($respond, '');

        if (count($mapped) <= 0) {
            return false;
        }

        $callToActions = [];

        foreach ($mapped as $message) {
            if ($message instanceof Message) {
                if ($message->getMessage() instanceof MessageButton) {
                    $callToActions[] = $message->getMessage()->getData();
                }
            }
        }

        $client = new Client();

        $status = false;

        try {
            $client->post($this->url(), [
                'form_params' => [
                    'setting_type' => 'call_to_actions',
                    'thread_state' => 'existing_thread',
                    'call_to_actions' => $callToActions,
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
