<?php

namespace App\Jobs\Recipients;

use App\Jobs\Job;
use App\Models\Recipient;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchRecipientDataJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var string
     */
    protected $url = 'https://graph.facebook.com/v2.6/{reference}/?fields=first_name,last_name,profile_pic,locale,timezone,gender&access_token={token}';

    /**
     * @var string
     */
    protected $reference;

    /**
     * @var string
     */
    protected $token;

    /**
     * @param $reference
     * @param $token
     */
    public function __construct($reference, $token)
    {
        $this->reference = $reference;
        $this->token = $token;
    }

    /**
     * Fetch and save user data.
     *
     * @param Dispatcher $dispatcher
     * @return array
     */
    public function handle(Dispatcher $dispatcher)
    {
        try {
            return (array) json_decode(file_get_contents($this->url()));
        } catch (\Exception $e) {
            logger($e);
        }

        return [];
    }

    /**
     * @return string
     */
    protected function url()
    {
        return str_replace(['{reference}', '{token}'], [$this->reference, $this->token], $this->url);
    }
}
