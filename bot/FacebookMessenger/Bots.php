<?php

namespace Bot\FacebookMessenger;

use pimax\FbBotApp;

class Bots
{
    /**
     * @var array
     */
    protected $bots = [];

    /**
     * @param string $token
     * @return FbBotApp
     */
    public function get($token)
    {
        if (!isset($this->bots[$token])) {
            $this->bots[$token] = new FbBotApp($token);
        }

        return $this->bots[$token];
    }
}
