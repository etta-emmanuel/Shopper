<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductObserver
{
    public function creating(Product $product): void
    {
        $product->slug = Str::slug($product->name);
    }

    public function created(Product $product): void
    {
    }

    public function updating(Product $product): void
    {
    }

    public function updated(Product $product): void
    {
    }

    public function saving(Product $product): void
    {
    }

    public function saved(Product $product): void
    {
    }

    public function deleting(Product $product): void
    {
    }

    public function deleted(Product $product): void
    {
    }
}
