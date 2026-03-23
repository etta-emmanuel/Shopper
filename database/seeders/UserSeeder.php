<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Etta Emanuel',
                'email' => 'ettaemmanuelminteh@gmail.com',
                'password' => bcrypt('Emmanuel1.'),
                'type' => 'admin',
            ],
            [
                'name' => 'Real Me',
                'email' => 'iam.ethanal.7@gmail.com',
                'password' => bcrypt('Emmanuel1.'),
                'type' => 'customer',
            ]
        ];
        foreach ($users as $user) {
            User::factory()->create($user);
        }
        User::factory(10)->create();
    }
}
