<?php

namespace App\Models;

use App\Models\Concerns\HasImages;
use App\Observers\ProductObserver;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[ObservedBy([ProductObserver::class])]
#[Guarded([])]
class Product extends BaseModel
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory, HasImages;

    public function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
            'discount' => 'decimal:2',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
