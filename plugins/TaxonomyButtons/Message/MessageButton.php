<?php

namespace Plugins\TaxonomyButtons\Message;

class MessageButton extends \pimax\Messages\MessageButton
{
    /**
     * Postback button type
     */
    const TYPE_PHONE_NUMBER = "phone_number";

    /**
     * Get Button data
     *
     * @return array
     */
    public function getData()
    {
        if ($this->type == self::TYPE_PHONE_NUMBER) {
            return [
                'type' => $this->type,
                'title' => $this->title,
                'payload' => $this->url,
            ];
        }

        return parent::getData();
    }
}
