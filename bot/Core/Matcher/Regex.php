<?php

namespace Bot\Core\Matcher;

use Bot\Core\Contract\Matcher;

class Regex implements Matcher
{
    /**
     * @var string
     */
    protected $pattern;

    /**
     * Equals constructor.
     * @param $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * Determine if input has matched.
     *
     * @param mixed $input
     * @return bool
     */
    public function matches($input)
    {
        return preg_match($this->pattern, $input) === 1 ? true : false;
    }
}
