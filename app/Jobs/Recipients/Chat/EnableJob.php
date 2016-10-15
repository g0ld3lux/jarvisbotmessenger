<?php

namespace App\Jobs\Recipients\Chat;

class EnableJob extends Job
{
    /**
     * @return boolean
     */
    protected function enabled()
    {
        return true;
    }
}
