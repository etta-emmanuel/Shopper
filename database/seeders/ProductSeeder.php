<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::factory()
            ->count(18)
            ->create()
            ->each(function (Product $product): void {
                Image::factory()
                    ->count(rand(1, 3))
                    ->for($product, 'imageable')
                    ->create();
            });
    }
}
