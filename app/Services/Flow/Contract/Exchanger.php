<?php

namespace App\Services\Flow\Contract;

use App\Models\Bot;

interface Exchanger
{
    /**
     * Import data.
     *
     * @param Bot $bot
     * @param object $data
     * @return bool
     */
    public function import(Bot $bot, $data);

    /**
     * Export flows.
     *
     * @param array $flows
     * @return array
     */
    public function export(array $flows);
}
