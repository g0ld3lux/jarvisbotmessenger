<?php

namespace Bot\Core\Matcher;

use Bot\Core\Contract\Matcher;
use NlpTools\Similarity\SimilarityInterface;
use NlpTools\Tokenizers\TokenizerInterface;

class Text implements Matcher
{
    /**
     * @var string
     */
    protected $text;

    /**
     * @var float
     */
    protected $sensitivity;

    /**
     * @var TokenizerInterface
     */
    protected $tokenizer;

    /**
     * @var SimilarityInterface
     */
    protected $similarity;

    /**
     * @param string $text
     * @param float $sensitivity
     * @param TokenizerInterface $tokenizer
     * @param SimilarityInterface $similarity
     */
    public function __construct($text, $sensitivity, TokenizerInterface $tokenizer, SimilarityInterface $similarity)
    {
        $this->text = $text;
        $this->sensitivity = $sensitivity;
        $this->tokenizer = $tokenizer;
        $this->similarity = $similarity;
    }

    /**
     * Determine if input has matched.
     *
     * @param mixed $input
     * @return bool
     */
    public function matches($input)
    {
        $string1 = $this->tokenize($this->text);
        $string2 = $this->tokenize($input);

        $similarity = $this->similarity->similarity($string1, $string2);

        return $similarity >= $this->sensitivity;
    }

    /**
     * @param $string
     * @return array
     */
    protected function tokenize($string)
    {
        return $this->tokenizer->tokenize($string);
    }
}
