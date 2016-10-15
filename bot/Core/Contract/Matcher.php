<?php

namespace Bot\Core\Contract;

interface Matcher
{
    /**
     * Determine if input has matched.
     *
     * @param mixed $input
     * @return bool
     */
    public function matches($input);
}
