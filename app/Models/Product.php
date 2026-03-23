<?php

namespace App\Models;

use App\Models\Concerns\HasImages;
use App\Observers\Observable;
use App\Observers\ProductObserver;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[ObservedBy([ProductObserver::class])]
#[Fillable(['name', 'slug', 'base_price', 'discount'])]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory, HasImages, Observable;

    protected $guarded = [];
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
