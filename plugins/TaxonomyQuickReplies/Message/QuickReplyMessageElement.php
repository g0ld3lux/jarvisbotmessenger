<?php

namespace Plugins\TaxonomyQuickReplies\Message;

class QuickReplyMessageElement
{
    /**
     * @var string
     */
    protected $contentType = null;

    /**
     * @var string
     */
    protected $title = null;

    /**
     * @var string
     */
    protected $payload = null;

    /**
     * Message constructor.
     *
     * @param $contentType
     * @param $title
     * @param $payload
     */
    public function __construct($contentType, $title, $payload)
    {
        $this->contentType = $contentType;
        $this->title = $title;
        $this->payload = $payload;

    }

    /**
     * Get message data
     *
     * @return array
     */
    public function getData()
    {
        return [
            'content_type' => $this->contentType,
            'title' => $this->title,
            'payload' => $this->payload,
        ];
    }
}
