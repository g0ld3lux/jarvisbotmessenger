<?php

namespace Plugins\TaxonomyCallback\Jobs\Executable;

use App\Models\Project;
use App\Models\Recipient;
use Bot\Core\Contract\Executable;
use Bot\Core\Executor;
use Bot\Core\Jobs\Job;
use Bot\Core\Respond\Flow;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use pimax\FbBotApp;
use pimax\Messages\ImageMessage;
use pimax\Messages\Message;
use Bot\FacebookMessenger\Executable\Message as ExecutableMessage;
use pimax\Messages\MessageButton;
use pimax\Messages\MessageElement;
use pimax\Messages\StructuredMessage;
use Plugins\TaxonomyAudio\Message\AudioMessage;
use Plugins\TaxonomyFile\Message\FileMessage;
use Plugins\TaxonomyVideo\Message\VideoMessage;

class CallbackJob extends Job
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var Flow|null
     */
    protected $flow;

    /**
     * @var Project
     */
    protected $project;

    /**
     * @var Recipient
     */
    protected $recipient;

    /**
     * @var FbBotApp
     */
    protected $botApp;

    /**
     * PingJob constructor.
     * @param string $url
     * @param string $type
     * @param string $text
     * @param null|Flow $flow
     * @param Project $project
     * @param Recipient $recipient
     * @param FbBotApp $botApp
     */
    public function __construct($url, $type, $text, $flow, Project $project, Recipient $recipient, FbBotApp $botApp)
    {
        $this->url = $url;
        $this->type = $type;
        $this->text = $text;
        $this->flow = $flow;
        $this->project = $project;
        $this->recipient = $recipient;
        $this->botApp = $botApp;
    }

    /**
     * Send message.
     *
     * @param Executor $executor
     */
    public function handle(Executor $executor)
    {
        $client = new Client();

        $response = $client->get($this->url, [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'query' => $this->query(),
        ]);

        if ($response->getStatusCode() != 200) {
            return;
        }

        $body = json_decode($response->getBody()->getContents());

        if (is_array($body)) {
            foreach ($body as $item) {
                try {
                    $executor->execute(
                        $this->type,
                        $this->text,
                        $this->flow,
                        $this->project,
                        $this->recipient,
                        $this->map($item),
                        $this->botApp
                    );
                } catch (\Exception $e) {
                    logger($e);
                }
            }
        }
    }

    /**
     * @return array
     */
    protected function query()
    {
        $query = [];

        $query['incoming'] = $this->queryIncoming();

        $query['project'] = $this->queryProject();

        $query['flow'] = $this->queryFlow();

        $query['recipient'] = $this->queryRecipient();

        return $query;
    }

    /**
     * @return array
     */
    protected function queryIncoming()
    {
        return ['type' => $this->type, 'text' => $this->text];
    }

    /**
     * @return array
     */
    protected function queryProject()
    {
        return ['id' => $this->project->id, 'title' => $this->project->title];
    }

    /**
     * @return array
     */
    protected function queryFlow()
    {
        if ($this->flow && $this->flow->getOriginal()) {
            return ['id' => $this->flow->getOriginal()->id, 'title' => $this->flow->getOriginal()->title];
        }

        return [];
    }

    /**
     * @return array
     */
    protected function queryRecipient()
    {
        $data = ['id' => $this->recipient->id];

        $recipientVariables = Recipient\Variable\Relation::with('variable', 'values')
            ->where('recipient_id', $this->recipient->id)
            ->get();

        foreach ($recipientVariables as $variable) {
            $data[$variable->variable->accessor] = $variable->getParamValue('text');
        }

        return $data;
    }

    /**
     * @param $item
     * @return Executable
     */
    protected function map($item)
    {
        $method = 'map' . Str::studly($item->type);

        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], [$item]);
        }

        return null;
    }

    /**
     * @param $item
     * @return array
     * @throws \Exception
     */
    protected function mapText($item)
    {
        if (isset($item->payload->text) && Str::length($item->payload->text) > 0) {
            return new ExecutableMessage(new Message($this->recipient->reference, $item->payload->text));
        }

        throw new \Exception('No text was set.');
    }

    /**
     * @param $item
     * @return array
     * @throws \Exception
     */
    protected function mapVideo($item)
    {
        if (isset($item->payload->url) && Str::length($item->payload->url) > 0) {
            return new ExecutableMessage(new VideoMessage($this->recipient->reference, $item->payload->url));
        }

        throw new \Exception('No URL was set.');
    }

    /**
     * @param $item
     * @return array
     * @throws \Exception
     */
    protected function mapAudio($item)
    {
        if (isset($item->payload->url) && Str::length($item->payload->url) > 0) {
            return new ExecutableMessage(new AudioMessage($this->recipient->reference, $item->payload->url));
        }

        throw new \Exception('No URL was set.');
    }

    /**
     * @param $item
     * @return array
     * @throws \Exception
     */
    protected function mapImage($item)
    {
        if (isset($item->payload->url) && Str::length($item->payload->url) > 0) {
            return new ExecutableMessage(new ImageMessage($this->recipient->reference, $item->payload->url));
        }

        throw new \Exception('No URL was set.');
    }

    /**
     * @param $item
     * @return array
     * @throws \Exception
     */
    protected function mapFile($item)
    {
        if (isset($item->payload->url) && Str::length($item->payload->url) > 0) {
            return new ExecutableMessage(new FileMessage($this->recipient->reference, $item->payload->url));
        }

        throw new \Exception('No URL was set.');
    }

    /**
     * @param $item
     * @return array
     * @throws \Exception
     */
    protected function mapButtons($item)
    {
        if (!isset($item->payload->text) && Str::length($item->payload->text) <= 0) {
            throw new \Exception('No text was set.');
        }

        if (!isset($item->payload->buttons) || count($item->payload->buttons) <= 0) {
            throw new \Exception('No buttons was set.');
        }

        $buttons = [];

        foreach ($item->payload->buttons as $button) {
            $buttons[] = $this->mapButton($button);
        }

        if (count($buttons) > 0) {
            return new ExecutableMessage(new StructuredMessage(
                $this->recipient->reference,
                StructuredMessage::TYPE_BUTTON,
                [
                    'text' => $item->payload->text,
                    'buttons' => $buttons,
                ]
            ));
        }

        throw new \Exception('No buttons was set.');
    }

    /**
     * @param $item
     * @return array
     * @throws \Exception
     */
    protected function mapCarousel($item)
    {
        if (!isset($item->payload->elements) || count($item->payload->elements) <= 0) {
            throw new \Exception('No elements was set.');
        }

        $elements = [];

        foreach ($item->payload->elements as $element) {
            $elements[] = $this->mapElement($element);
        }

        if (count($elements) > 0) {
            return new ExecutableMessage(new StructuredMessage(
                $this->recipient->reference,
                StructuredMessage::TYPE_GENERIC,
                [
                    'elements' => $elements,
                ]
            ));
        }

        throw new \Exception('No elements was set.');
    }

    /**
     * @param $button
     * @return MessageButton
     * @throws \Exception
     */
    protected function mapButton($button)
    {
        if (!isset($button->type) || $button->type != 'web_url') {
            throw new \Exception('Button option is invalid.');
        }

        if (!isset($button->title) || Str::length($button->title) <= 0) {
            throw new \Exception('Button title is not set.');
        }

        if (!isset($button->url) || Str::length($button->url) <= 0) {
            throw new \Exception('Button URL is not set.');
        }

        return new MessageButton($button->type, $button->title, $button->url);
    }

    /**
     * @param $element
     * @return MessageElement
     * @throws \Exception
     */
    protected function mapElement($element)
    {
        if (!isset($element->title) || Str::length($element->title) <= 0) {
            throw new \Exception('Element title is not set.');
        }

        if (!isset($element->image_url) || Str::length($element->image_url) <= 0) {
            throw new \Exception('Element URL is not set.');
        }

        $buttons = [];

        if (isset($element->buttons) && count($element->buttons) > 0) {
            foreach ($element->buttons as $button) {
                $buttons[] = $this->mapButton($button);
            }
        }

        return new MessageElement($element->title, $element->sub_title, $element->image_url, $buttons);
    }
}
