<?php

namespace App\Services;

use App\Models\Flow;
use App\Models\Flow\Matcher as MatcherModel;
use App\Models\Recipient;
use Bot\Core\Matcher;
use App\Models\Bot;
use App\Models\Respond;

class GetStartedMatcher extends RespondMatcher
{
    /**
     * Match input and return respond object.
     *
     * @param Bot $bot
     * @param Recipient $recipient
     * @param string $input
     * @return \Bot\Core\Respond\Respond[]
     * @throws \Exception
     */
    public function match(Bot $bot, Recipient $recipient, $input)
    {
        $input = str_replace('$$GETSTARTED$$', '', $input);

        try {
            return [
                $responds[] = $this->respond($bot->responds()->findOrFail($input), $recipient),
            ];
        } catch (\Exception $e) {
            logger($e);
        }


        throw new \Exception('Get started does not match.');
    }
}
