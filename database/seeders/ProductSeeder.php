<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Honey bees special shawarma with cheese',
            'Ofe Akwu',
            'Eba',
            'sausage roll',
            'Chicken Fantasy ',
            'Doughnut Jam',
            'Creamy seafood pasta',
            'Toast bread',
            'Meatpie',
            'Chicken pie',
            'Bottled water',
            'Afang Soup full portion',
            'Avocado and Egg Salad ',
            'baked potatoes',
            'Basmati Jollof Rice',
            'Beans Porridge',
            'Beef',
            'beef shawarma',
            'Boiled egg',
        ];
        foreach ($names as $name) {
            $multiplier = rand(15, 75);
            Product::factory()->create([
                'name' => $name,
                'slug' => Str::slug($name),
                'quantity' => rand(100, 150),
                'base_price' => $multiplier * 100,
            ]);
        }
    }
}
