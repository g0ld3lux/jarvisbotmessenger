<?php

namespace Plugins\TaxonomyRss\Jobs\Executable;

use App\Models\Recipient;
use Bot\Core\Jobs\Job;
use Goutte\Client;
use Illuminate\Contracts\Cache\Repository;
use PicoFeed\Parser\Item;
use PicoFeed\PicoFeedException;
use PicoFeed\Reader\Reader;
use pimax\FbBotApp;
use pimax\Messages\MessageButton;
use pimax\Messages\MessageElement;
use pimax\Messages\StructuredMessage;
use Symfony\Component\DomCrawler\Crawler;

class RssJob extends Job
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var int
     */
    protected $count;

    /**
     * @var string
     */
    protected $textLink;

    /**
     * @var FbBotApp
     */
    protected $botApp;

    /**
     * @var Recipient
     */
    protected $recipient;

    /**
     * @param string $url
     * @param int $count
     * @param string $textLink
     * @param Recipient $recipient
     * @param FbBotApp $botApp
     */
    public function __construct($url, $count, $textLink, Recipient $recipient, FbBotApp $botApp)
    {
        $this->url = $url;
        $this->count = $count;
        $this->textLink = $textLink;
        $this->recipient = $recipient;
        $this->botApp = $botApp;
    }

    /**
     * @param Repository $cache
     * @throws \PicoFeed\Parser\MalformedXmlException
     * @throws \PicoFeed\Reader\UnsupportedFeedFormatException
     */
    public function handle(Repository $cache)
    {
        try {
            $elements = [];

            $reader = new Reader();

            $resource = $cache->remember($this->key('feed', $this->url), 60, function () use ($reader) {
                logger('feed cache');
                return $reader->download($this->url);
            });

            $parser = $reader->getParser(
                $resource->getUrl(),
                $resource->getContent(),
                $resource->getEncoding()
            );

            $feed = $parser->execute();

            foreach ($feed->getItems() as $item) {
                if (count($elements) >= $this->count) {
                    break;
                }

                if ($element = $this->element($cache, $item)) {
                    $elements[] = $element;
                }
            }

            if (count($elements) > 0) {
                $this->botApp->send(new StructuredMessage(
                    $this->recipient->reference,
                    StructuredMessage::TYPE_GENERIC,
                    [
                        'elements' => $elements,
                    ]
                ));
            }
        } catch (PicoFeedException $e) {
            logger($e);
        }
    }

    /**
     * @param string $type
     * @param string $url
     * @return string
     */
    protected function key($type, $url)
    {
        return $type.'.'.md5($url);
    }

    /**
     * @param Repository $cache
     * @param Item $item
     * @return MessageElement
     */
    protected function element(Repository $cache, Item $item)
    {
        return new MessageElement(
            $this->title($item),
            $this->subTitle($item),
            $this->image($cache, $item),
            $this->buttons($item)
        );
    }

    /**
     * @param Item $item
     * @return string
     */
    protected function title(Item $item)
    {
        return html_entity_decode($item->getTitle());
    }

    /**
     * @param Item $item
     * @return string
     */
    protected function subTitle(Item $item)
    {
        return $item->getDate()->format('M j, Y').', '.$item->getAuthor();
    }

    /**
     * @param Repository $cache
     * @param Item $item
     * @return string
     */
    protected function image(Repository $cache, Item $item)
    {
        return $cache->remember($this->key('image', $item->getUrl()), 60, function () use ($item) {
            logger('image cache: '.$item->getUrl());
            $client = new Client();

            $crawler = $client->request('GET', $item->getUrl());

            $image = '';

            $crawler->filter('meta')->each(function (Crawler $node) use (&$image) {
                if ($node->attr('property') == 'og:image') {
                    $image = $node->attr('content');
                }
            });

            return $image;
        });
    }

    /**
     * @param Item $item
     * @return array
     */
    protected function buttons(Item $item)
    {
        return [
            new MessageButton('web_url', $this->textLink, $item->getUrl())
        ];
    }
}
