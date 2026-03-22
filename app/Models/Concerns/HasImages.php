<?php

namespace App\Models\Concerns;

use App\Models\Image;

trait HasImages
{
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function defaultImage()
    {
        return $this->morphOne(Image::class, 'imageable')->where('is_default', true);
    }
}
