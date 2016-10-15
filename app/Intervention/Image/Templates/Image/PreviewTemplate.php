<?php

namespace App\Intervention\Image\Templates\Image;

use Intervention\Image\Filters\FilterInterface;

class PreviewTemplate implements FilterInterface
{
    /**
     * Applies filter to given image
     *
     * @param  \Intervention\Image\Image $image
     * @return \Intervention\Image\Image
     */
    public function applyFilter(\Intervention\Image\Image $image)
    {
        return $image->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        });
    }
}
