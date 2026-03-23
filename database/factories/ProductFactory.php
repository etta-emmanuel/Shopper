<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(rand(2, 3), true);
        $basePrice = fake()->randomFloat(2, 20, 500);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            'base_price' => $basePrice,
        ];
    }
}
