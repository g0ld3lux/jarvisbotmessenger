<?php

namespace App\Intervention\Image\Templates\Recipient;

use Intervention\Image\Filters\FilterInterface;

class SmallTemplate implements FilterInterface
{
    /**
     * Applies filter to given image
     *
     * @param  \Intervention\Image\Image $image
     * @return \Intervention\Image\Image
     */
    public function applyFilter(\Intervention\Image\Image $image)
    {
        return $image->fit(32, 32);
    }
}
