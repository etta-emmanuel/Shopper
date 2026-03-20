<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->admin()->create();

        Image::factory()
            ->count(1)
            ->for($admin, 'imageable')
            ->create();

        User::factory()
            ->count(9)
            ->create()
            ->each(function (User $user): void {
                Image::factory()
                    ->count(rand(1, 2))
                    ->for($user, 'imageable')
                    ->create();
            });
    }
}
