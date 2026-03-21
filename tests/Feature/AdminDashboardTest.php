<?php

use App\Models\Product;
use App\Models\User;

it('renders the admin dashboard for authenticated users', function (): void {
    $user = User::factory()->create();
    Product::factory()->count(3)->create();

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertOk();
});

it('redirects guests away from the admin dashboard', function (): void {
    $this->get('/dashboard')
        ->assertRedirect('/login');
});
