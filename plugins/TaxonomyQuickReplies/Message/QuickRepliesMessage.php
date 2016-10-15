<?php

namespace Plugins\TaxonomyQuickReplies\Message;

class QuickRepliesMessage
{
    /**
     * @var integer|null
     */
    protected $recipient = null;

    /**
     * @var string
     */
    protected $data = null;

    /**
     * Message constructor.
     *
     * @param $recipient
     * @param $data
     */
    public function __construct($recipient, $data)
    {
        $this->recipient = $recipient;
        $this->data = $data;

    }

    /**
     * Get message data
     *
     * @return array
     */
    public function getData()
    {
        $result = [
            'recipient' =>  [
                'id' => $this->recipient,
            ],
            'message' => [
                'text' => $this->data['text'],
                'quick_replies' => [],
            ],
        ];

        foreach ($this->data['quick_replies'] as $quick_reply) {
            $result['message']['quick_replies'][] = $quick_reply->getData();
        }

        return $result;
    }
}
