<?php

namespace App\Services\Flow;

use App\Models\Bot;
use App\Services\Flow\Contract\Exchanger;
use Carbon\Carbon;

class Exchange
{
    /**
     * @var array
     */
    protected $exchangers = [];

    /**
     * @param $version
     * @param Exchanger $exchanger
     */
    public function addExchanger($version, Exchanger $exchanger)
    {
        if (isset($this->exchangers[$version])) {
            throw new \RuntimeException('Exchanger for "'.$version.'" already added.');
        }

        $this->exchangers[$version] = $exchanger;
    }

    /**
     * @param $version
     * @return Exchanger
     */
    public function exchanger($version)
    {
        if (!isset($this->exchangers[$version])) {
            throw new \RuntimeException('Exchanger for "'.$version.'" not found.');
        }

        return $this->exchangers[$version];
    }

    /**
     * @param Bot $bot
     * @param object $data
     * @param $version
     * @return bool
     */
    public function import(Bot $bot, $data, $version)
    {
        return $this->exchanger($version)->import($bot, $data);
    }

    /**
     * @param array $flows
     * @param $version
     * @return array
     */
    public function export(array $flows, $version)
    {
        $exchanger = $this->exchanger($version);

        return array_merge([
            'meta' => [
                'version' => $version,
                'date' => (new Carbon())->format(Carbon::ATOM),
            ],
        ], $exchanger->export($flows));
    }
}
