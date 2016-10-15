<?php

namespace App\Jobs\Facebook;

use App\Jobs\Job;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchLongLivedTokenJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var string
     */
    protected $url = 'https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id={app-id}&client_secret={app-secret}&fb_exchange_token={token}';

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * SubscribeProjectJob constructor.
     * @param string $accessToken
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return boolean
     */
    public function handle()
    {
        $client = new Client();

        try {
            $response = $client->get(
                str_replace(
                    [
                        '{app-id}',
                        '{app-secret}',
                        '{token}'
                    ],
                    [
                        config('services.facebook.client_id'),
                        config('services.facebook.client_secret'),
                        $this->accessToken
                    ],
                    $this->url
                )
            )->getBody()->getContents();

            $string = str_replace(['access_token=', 'expires='], ['', ''], $response);

            $string = explode('&', $string);

            return [
                'token' => isset($string[0]) ? $string[0] : '',
                'expires' => isset($string[1]) ? new Carbon('+'.$string[1].' seconds') : null,
            ];
        } catch (\Exception $e) {
            return [
                'token' => $this->accessToken,
                'expires' => new Carbon('+1 hour'),
            ];
        }
    }
}
