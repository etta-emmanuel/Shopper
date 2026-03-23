<?php

use App\Models\Product;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('renders the products index page', function (): void {
    Product::factory()->count(3)->create();

    $this->get('/products')
        ->assertOk();
});

it('allows sanctum-authenticated users to manage products via the api resource', function (): void {
    $admin = User::factory()->create();
    Sanctum::actingAs($admin);

    $createResponse = $this->postJson('/api/products', [
        'name' => 'Canvas Shopper Bag',
        'base_price' => 120,
        'discount' => 10,
    ]);

    $createResponse
        ->assertCreated()
        ->assertJsonPath('data.name', 'Canvas Shopper Bag');

    $slug = $createResponse->json('data.slug');
    $id = $createResponse->json('data.id');

    $this->putJson("/api/products/{$slug}", [
        'name' => 'Canvas Shopper Bag Premium',
        'slug' => $slug,
        'base_price' => 150,
        'discount' => 20,
    ])->assertOk()
        ->assertJsonPath('data.base_price', 150);

    $this->deleteJson("/api/products/{$slug}")
        ->assertOk();

    $this->assertDatabaseMissing('products', [
        'id' => $id,
    ]);
});

it('requires sanctum authentication for non-get product api routes', function (): void {
    $this->postJson('/api/products', [
        'name' => 'Guest Product',
        'base_price' => 100,
        'discount' => 0,
    ])->assertUnauthorized();
});
