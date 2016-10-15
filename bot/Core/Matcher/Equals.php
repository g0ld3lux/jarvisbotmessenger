<?php

namespace Bot\Core\Matcher;

use Bot\Core\Contract\Matcher;

class Equals implements Matcher
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
        if ($this->case == static::CASE_SENSITIVE) {
            return strcmp($this->text, $input) === 0;
        }

        if ($this->case == static::CASE_INSENSITIVE) {
            return strcasecmp($this->text, $input) === 0;
        }

        return $this->text == $input;
    }
}
