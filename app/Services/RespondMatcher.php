<?php

namespace App\Services;

use App\Models\Flow;
use App\Models\Flow\Matcher as MatcherModel;
use App\Models\Recipient;
use Bot\Core\Matcher;
use App\Models\Bot;
use App\Models\Respond;
use Bot\Core\Respond\Taxonomy;
use NlpTools\Similarity\CosineSimilarity;
use NlpTools\Tokenizers\WhitespaceTokenizer;

class RespondMatcher
{
    /**
     * @var RecipientVariableReplacer
     */
    protected $replacer;

    /**
     * RespondMatcher constructor.
     * @param RecipientVariableReplacer $replacer
     */
    public function __construct(RecipientVariableReplacer $replacer)
    {
        $this->replacer = $replacer;
    }

    /**
     * Match input and return respond object.
     *
     * @param Bot $bot
     * @param Recipient $recipient
     * @param string $input
     * @return \Bot\Core\Respond\Flow
     * @throws \Exception
     */
    public function match(Bot $bot, Recipient $recipient, $input)
    {
        $flows = Flow::with(['matchers', 'matchers.params', 'responds.taxonomies', 'responds'])
        ->where('bot_id', $bot->id)
        ->ordered()
        ->get();

        /** @var Respond $respond */
        foreach ($flows as $flow) {
            $mismatched = false;

            if (count($flow->matchers) > 0) {
                /** @var MatcherModel $matcher */
                foreach ($flow->matchers as $matcher) {
                    if (!$this->matches($matcher, $input)) {
                        $mismatched = true;
                    }
                }
            } else {
                $mismatched = true;
            }

            if (!$mismatched) {
                return $this->flow($flow, $recipient);
            }
        }

        if ($default = $this->defaultFlow($bot)) {
            return $this->flow($default, $recipient);
        }

        throw new \Exception('Input does not matches any flow.');
    }

    /**
     * @param Bot $bot
     * @return Flow|null
     */
    protected function defaultFlow(Bot $bot)
    {
        return Flow::with(['matchers', 'matchers.params', 'responds.taxonomies', 'responds'])
        ->where('bot_id', $bot->id)
        ->whereNotNull('defaulted_at')
        ->ordered()
        ->first();
    }

    /**
     * @param Flow $flow
     * @param Recipient $recipient
     * @return \Bot\Core\Respond\Flow
     */
    public function flow(Flow $flow, Recipient $recipient)
    {
        $responds = [];

        foreach ($flow->responds as $respond) {
            $responds[] = $this->respond($respond, $recipient);
        }

        return new \Bot\Core\Respond\Flow($flow, $responds);
    }

    /**
     * @param Respond $respond
     * @param Recipient $recipient
     * @return \Bot\Core\Respond\Respond
     */
    public function respond(Respond $respond, Recipient $recipient)
    {
        $taxonomies = [];

        foreach ($respond->taxonomies()->ordered()->get() as $taxonomy) {
            $taxonomies[] = $this->taxonomy($taxonomy, $recipient);
        }

        return new \Bot\Core\Respond\Respond($respond, $taxonomies);
    }

    /**
     * @param Respond\Taxonomy $taxonomy
     * @param Recipient $recipient
     * @return Taxonomy
     */
    public function taxonomy(Respond\Taxonomy $taxonomy, Recipient $recipient)
    {
        $children = [];

        foreach ($taxonomy->children()->ordered()->get() as $child) {
            $children[] = $this->taxonomy($child, $recipient);
        }

        $attributes = array_map(function ($value) use ($recipient) {
            return $this->replacer->replace($recipient, $value);
        }, $taxonomy->params()->ordered()->lists('value', 'key')->all());

        return new Taxonomy($taxonomy, $taxonomy->type, $attributes, $children);
    }

    /**
     * @param MatcherModel $matcherModel
     * @param $input
     * @return bool
     */
    protected function matches(MatcherModel $matcherModel, $input)
    {
        $method = 'make'.ucfirst($matcherModel->type).'Matcher';

        if (method_exists($this, $method)) {
            return $this->{$method}($matcherModel)->matches($input);
        }

        return false;
    }

    /**
     * @param MatcherModel $matcherModel
     * @return Matcher\Equals
     */
    protected function makeEqualsMatcher(MatcherModel $matcherModel)
    {
        return new Matcher\Equals(
            $matcherModel->getParamValue('text'),
            $matcherModel->getParamValue('case')
        );
    }

    /**
     * @param MatcherModel $matcherModel
     * @return Matcher\Contains
     */
    protected function makeContainsMatcher(MatcherModel $matcherModel)
    {
        return new Matcher\Contains(
            $matcherModel->getParamValue('text'),
            $matcherModel->getParamValue('case')
        );
    }

    /**
     * @param MatcherModel $matcherModel
     * @return Matcher\Regex
     */
    protected function makeRegexMatcher(MatcherModel $matcherModel)
    {
        return new Matcher\Regex($matcherModel->getParamValue('pattern'));
    }

    /**
     * @param MatcherModel $matcherModel
     * @return Matcher\Text
     */
    protected function makeTextMatcher(MatcherModel $matcherModel)
    {
        return new Matcher\Text(
            $matcherModel->getParamValue('text'),
            $matcherModel->getParamValue('sensitivity'),
            new WhitespaceTokenizer(),
            new CosineSimilarity()
        );
    }
}
