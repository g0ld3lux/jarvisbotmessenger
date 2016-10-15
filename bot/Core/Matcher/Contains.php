<?php

namespace Bot\Core\Matcher;

use Bot\Core\Contract\Matcher;
use Illuminate\Support\Str;
use NlpTools\Tokenizers\WhitespaceAndPunctuationTokenizer;

class Contains implements Matcher
{
    /**
     * @var string
     */
    const CASE_SENSITIVE = 'sensitive';

    /**
     * @var string
     */
    const CASE_INSENSITIVE = 'insensitive';

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $case;

    /**
     * Equals constructor.
     * @param string $text
     * @param string|null $case
     */
    public function __construct($text, $case = null)
    {
        $this->text = $text;
        $this->case = $case;
    }

    /**
     * Determine if input has matched.
     *
     * @param mixed $input
     * @return bool
     */
    public function matches($input)
    {
        $input = $this->case == static::CASE_SENSITIVE ? $input : Str::lower($input);
        $text = $this->case == static::CASE_SENSITIVE ? $this->text : Str::lower($this->text);

        $tokenizer = new WhitespaceAndPunctuationTokenizer();

        $tokenized = $tokenizer->tokenize($input);

        return in_array($text, $tokenized);
    }
}
