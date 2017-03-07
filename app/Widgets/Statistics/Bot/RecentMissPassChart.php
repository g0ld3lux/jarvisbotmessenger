<?php

namespace App\Widgets\Statistics\Bot;

use Arrilot\Widgets\AbstractWidget;
use App\Services\Statistics;
use Carbon\Carbon;

class RecentMissPassChart extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'bot' => null,
    ];

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function run()
    {
        $statistics = app(Statistics\Bot::class)->getValues(
            $this->config['bot'],
            ['pass', 'miss'],
            new Carbon('-30 days')
        );

        $labels = array_keys($statistics);

        return view('widgets.statistics.bot.recent_miss_pass_chart', [
            'labels' => $labels,
            'miss' => $this->extract('miss', $statistics, $labels),
            'pass' => $this->extract('pass', $statistics, $labels),
        ]);
    }

    /**
     * @param $key
     * @param array $statistics
     * @param array $labels
     * @return array
     */
    protected function extract($key, array $statistics, array $labels)
    {
        $data = [];

        foreach ($labels as $label) {
            $data[$label] = array_get($statistics, $label.'.'.$key, 0);
        }

        return $data;
    }
}
