<?php

namespace App\Services\Statistics;

use App\Models\Bot as BotModel;
use Carbon\Carbon;

class Bot
{
    /**
     * @param BotModel $bot
     * @param array $keys
     * @param Carbon|null $start
     * @param Carbon|null $end
     * @return array
     */
    public function getValues(BotModel $bot, array $keys, Carbon $start = null, Carbon $end = null)
    {
        $start = $start ?: $this->getBotMin($bot);
        $end = $end ?: new Carbon('now');

        $statistics = [];

        $entries = $bot
            ->statistics()
            ->select('key', 'value', 'date_at')
            ->whereIn('key', $keys)
            ->whereBetween('statistics.date_at', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->get();

        foreach ($entries as $statistic) {
            if (!isset($statistics[$statistic->date_at->format('Y-m-d')])) {
                $statistics[$statistic->date_at->format('Y-m-d')] = [];
            }

            $statistics[$statistic->date_at->format('Y-m-d')][$statistic->key] = $statistic->value;
        }

        return $this->values($keys, $start, $end, $statistics);
    }

    /**
     * @param BotModel $bot
     * @param array $keys
     * @param Carbon|null $start
     * @param Carbon|null $end
     * @return array
     */
    public function sumValues(BotModel $bot, array $keys, Carbon $start = null, Carbon $end = null)
    {
        $start = $start ?: $this->getBotMin($bot);
        $end = $end ?: new Carbon('now');

        $statistics = [];

        foreach ($keys as $key) {
            $statistics[$key] = $bot
                ->statistics()
                ->where('key', $key)
                ->whereBetween('statistics.date_at', [$start->format('Y-m-d'), $end->format('Y-m-d')])
                ->sum('value');
        }

        return $statistics;
    }

    /**
     * Return min date for a given bot.
     *
     * @param BotModel $bot
     * @return Carbon
     */
    protected function getBotMin(BotModel $bot)
    {
        $date = $bot->created_at;

        return $date ? new Carbon($date) : new Carbon('now');
    }

    /**
     * Format statistics array.
     *
     * @param array $keys
     * @param Carbon $start
     * @param Carbon $end
     * @param array $statistics
     * @return array
     */
    protected function values(array $keys, Carbon $start, Carbon $end, array $statistics = [])
    {
        $values = [];

        $date = clone $start;

        $days = $start->diffInDays($end);

        for ($i = 0; $i <= $days; $i++) {
            foreach ($keys as $key) {
                array_set(
                    $values,
                    $date->format('Y-m-d').'.'.$key,
                    array_get($statistics, $date->format('Y-m-d').'.'.$key, 0)
                );
            }
            $date = $date->addDays(1);
        }

        return $values;
    }
}
