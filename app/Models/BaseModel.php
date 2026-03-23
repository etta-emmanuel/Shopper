<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeActive()
    {
        return $this->active === true;
    }
}
