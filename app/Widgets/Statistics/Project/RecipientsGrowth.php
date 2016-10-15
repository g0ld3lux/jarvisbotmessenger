<?php

namespace App\Widgets\Statistics\Project;

use Arrilot\Widgets\AbstractWidget;
use App\Services\Statistics;
use Carbon\Carbon;
use DB;

class RecipientsGrowth extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'project' => null,
    ];

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function run()
    {
        /** @var Statistics\Project $service */
        $service = app(Statistics\Project::class);

        $statistics = $service->getValues($this->config['project'], ['recipients'], new Carbon('-30 days'));

        $totalBefore = (int) array_get($service->sumValues(
            $this->config['project'],
            ['recipients'],
            $this->getMinDate(),
            new Carbon('-29 days')
        ), 'recipients', 0);

        $labels = array_keys($statistics);

        $recipients = $this->extract('recipients', $statistics, $labels);

        $totals = [];

        foreach ($recipients as $key => $value) {
            $totalBefore += $value;
            $totals[$key] = $totalBefore;
        }

        return view('widgets.statistics.project.recipients_growth', [
            'labels' => $labels,
            'recipients' => $recipients,
            'totals' => $totals,
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

    /**
     * @return Carbon
     */
    protected function getMinDate()
    {
        return new Carbon($this->config['project']->statistics()->where('key', 'recipients')->min('date_at'));
    }
}
