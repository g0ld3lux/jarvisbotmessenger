<?php

namespace App\Jobs\Recipients\Chat;

class DisableJob extends Job
{
    /**
     * @return boolean
     */
    protected function enabled()
    {
        return false;
    }
}
