<?php

namespace App\Services\Taxonomies;

use App\Contracts\TaxonomyCreateLink;

class CreateLinkRegistry
{
    const MESSAGE = 'message';

    const PLUGIN = 'plugin';

    const HOOK = 'hook';

    /**
     * @var []
     */
    protected $items;

    /**
     * @param $type
     * @param TaxonomyCreateLink $item
     * @param null $priority
     */
    public function add($type, TaxonomyCreateLink $item, $priority = null)
    {
        $this->links($type)->insert($item, $priority);
    }

    /**
     * @param $type
     * @return \SplPriorityQueue
     */
    public function links($type)
    {
        if (!isset($this->items[$type])) {
            $this->items[$type] = new \SplPriorityQueue();
        }

        return $this->items[$type];
    }

    /**
     * @param $type
     * @return array
     */
    public function items($type)
    {
        $items = [];

        foreach (clone $this->links($type) as $item) {
            $items[] = $item;
        }

        return $items;
    }
}
