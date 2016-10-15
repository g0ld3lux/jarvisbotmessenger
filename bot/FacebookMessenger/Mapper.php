<?php

namespace Bot\FacebookMessenger;

use Bot\Core\Contract\Executable;
use Bot\Core\Respond\Flow;
use Bot\Core\Respond\Respond;
use Bot\Core\Respond\Taxonomy;
use Bot\FacebookMessenger\Executable\Message as ExecutableMessage;

class Mapper
{
    /**
     * @var array
     */
    protected static $extensions = [];

    /**
     * @param $type
     * @param \Closure $callback
     */
    public static function extend($type, \Closure $callback)
    {
        if (array_has(static::$extensions, $type)) {
            throw new \InvalidArgumentException('Type "'.$type.'" already has a callback');
        }

        array_set(static::$extensions, $type, $callback);
    }

    /**
     * Map respond to message.
     *
     * @param Flow $flow
     * @param $recipient
     * @return Executable[]
     * @throws \Exception
     */
    public function map(Flow $flow, $recipient)
    {
        $messages = [];

        /** @var Taxonomy $taxonomy */
        foreach ($flow->getResponds() as $respond) {
            $messages = array_merge($messages, $this->mapRespond($respond, $recipient));
        }

        if (count($messages) > 0) {
            return $messages;
        }

        throw new \Exception('Failed to map respond.');
    }
    /**
     * Map respond to message.
     *
     * @param Respond $respond
     * @param $recipient
     * @return Executable[]
     * @throws \Exception
     */
    public function mapRespond(Respond $respond, $recipient)
    {
        $messages = [];

        /** @var Taxonomy $taxonomy */
        foreach ($respond->getTaxonomies() as $taxonomy) {
            $messages = array_merge($messages, $this->mapTaxonomy($taxonomy, $recipient));
        }

        if (count($messages) > 0) {
            return array_map(function ($message) {
                if (!($message instanceof Executable)) {
                    return new ExecutableMessage($message);
                }

                return $message;
            }, $messages);
        }

        throw new \Exception('Failed to map respond.');
    }

    /**
     * @param Taxonomy $taxonomy
     * @param $recipient
     * @return Executable[]
     */
    public function mapTaxonomy(Taxonomy $taxonomy, $recipient)
    {
        $messages = [];

        try {
            if (array_has(static::$extensions, $taxonomy->getType())) {
                $messages[] = call_user_func_array(
                    array_get(static::$extensions, $taxonomy->getType()),
                    [$taxonomy, $recipient, $this]
                );
            }
        } catch (\Exception $e) {
            logger($e);
        }

        return $messages;
    }
}
