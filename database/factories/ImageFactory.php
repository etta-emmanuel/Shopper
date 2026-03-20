<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Image>
 */
class ImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'img_url' => fake()->imageUrl(1200, 1200, 'fashion', true, 'shopper'),
            'alt_text' => fake()->sentence(3),
            'sort_order' => fake()->numberBetween(0, 4),
        ];
    }
}
