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
        $discount = fake()->randomElement([0, 0, 0, fake()->randomFloat(2, 5, 80)]);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name.'-'.fake()->unique()->numberBetween(10, 9999)),
            'base_price' => $basePrice,
            'discount' => min($discount, $basePrice),
        ];
    }
}
