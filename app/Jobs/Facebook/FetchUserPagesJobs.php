<?php

namespace App\Jobs\Facebook;

use App\Jobs\Job;
use Carbon\Carbon;
use Facebook\Facebook;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laravel\Socialite\Contracts\User;

class FetchUserPagesJobs extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param Facebook $facebook
     * @return array
     */
    public function handle(Facebook $facebook)
    {
        try {
            $response = $facebook->get('/'.$this->user->getId().'/accounts', $this->user->token);

            return array_get($response->getDecodedBody(), 'data', []);
        } catch (\Exception $e) {
            logger($e);
        }

        return [];
    }
}
