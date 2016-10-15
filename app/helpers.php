<?php

if (!function_exists('recipient_variables_list')) {
    /**
     * Return list of available variables.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function recipient_variables_list(\App\Models\Project $project)
    {
        return \App\Models\Recipient\Variable::where('project_id', $project->id)->orderBy('name', 'asc')->get();
    }
}

if (!function_exists('permissions_list')) {
    /**
     * @return array|null
     */
    function permissions_list()
    {
        static $permissions = null;

        if ($permissions === null) {
            $permissions = \App\Models\Permission::lists('permission', 'id')->all();
        }

        return $permissions;
    }
}

if (!function_exists('timezones_list')) {
    /**
     * @return array|null
     */
    function timezones_list()
    {
        static $timezones = null;

        if ($timezones === null) {
            $timezones = [];
            $offsets = [];
            $now = new DateTime();

            foreach (DateTimeZone::listIdentifiers() as $timezone) {
                $now->setTimezone(new DateTimeZone($timezone));
                $offsets[] = $offset = $now->getOffset();
                $timezones[$timezone] = '(' . format_GMT_offset($offset) . ') ' . format_timezone_name($timezone);
            }

            array_multisort($offsets, $timezones);
        }

        return $timezones;
    }
}

if (!function_exists('format_GMT_offset')) {
    /**
     * @param $offset
     * @return string
     */
    function format_GMT_offset($offset)
    {
        $hours = intval($offset / 3600);
        $minutes = abs(intval($offset % 3600 / 60));
        return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
    }
}

if (!function_exists('format_timezone_name')) {
    /**
     * @param $name
     * @return mixed
     */
    function format_timezone_name($name)
    {
        $name = str_replace('/', ', ', $name);
        $name = str_replace('_', ' ', $name);
        $name = str_replace('St ', 'St. ', $name);
        return $name;
    }
}

if (!function_exists('adjust_project_timezone')) {
    /**
     * @param \App\Models\Project $project
     * @param \Carbon\Carbon $date
     * @return \Carbon\Carbon
     */
    function adjust_project_timezone(\App\Models\Project $project, \Carbon\Carbon $date)
    {
        $clone = clone $date;
        $clone->setTimezone($project->timezone);

        return $clone;
    }
}

if (!function_exists('timezone_gmt_name_from_offset')) {
    /**
     * Return name of timezone based on offset.
     *
     * @param float|int|string $offset
     * @return string|null
     */
    function timezone_gmt_name_from_offset($offset)
    {
        if (is_null($offset)) {
            return null;
        }

        $offset *= 3600;

        static $timezones = [];

        return array_get($timezones, (string) $offset, function () use ($timezones, $offset) {
            $now = new DateTime();

            foreach (DateTimeZone::listIdentifiers() as $timezone) {
                $now->setTimezone(new DateTimeZone($timezone));
                if ($now->getOffset() == $offset) {
                    $gmtOffset = format_GMT_offset($offset);
                    array_set($timezones, (string) $offset, $gmtOffset);
                    return $gmtOffset;
                }
            }
        });
    }
}
