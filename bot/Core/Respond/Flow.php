<?php

namespace Bot\Core\Respond;

use App\Models\Flow as FlowModel;

class Flow
{
    /**
     * @var FlowModel
     */
    protected $original;

    /**
     * @var Respond[]
     */
    protected $responds;

    /**
     * Flow constructor.
     * @param FlowModel $original
     * @param array $responds
     */
    public function __construct(FlowModel $original, array $responds = [])
    {
        $this->original = $original;
        $this->responds = $responds;
    }

    /**
     * @return FlowModel
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * @return array|\Bot\Core\Respond\Respond[]
     */
    public function getResponds()
    {
        return $this->responds;
    }
}
