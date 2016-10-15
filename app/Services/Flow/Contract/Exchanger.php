<?php

namespace App\Services\Flow\Contract;

use App\Models\Project;

interface Exchanger
{
    /**
     * Import data.
     *
     * @param Project $project
     * @param object $data
     * @return bool
     */
    public function import(Project $project, $data);

    /**
     * Export flows.
     *
     * @param array $flows
     * @return array
     */
    public function export(array $flows);
}
