<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('registers a user from the web auth endpoint', function (): void {
    $response = $this->post('/register', [
        'name' => 'Taylor Shopper',
        'email' => 'taylor@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect();

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'taylor@example.com',
    ]);
});

it('manages users through the api resource controller', function (): void {
    $createResponse = $this->postJson('/api/users', [
        'name' => 'First User',
        'email' => 'first@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $createResponse
        ->assertCreated()
        ->assertJsonPath('data.name', 'First User');

    $userId = $createResponse->json('data.id');

    $this->getJson('/api/users')
        ->assertOk()
        ->assertJsonPath('data.0.email', 'first@example.com');

    $this->getJson("/api/users/{$userId}")
        ->assertOk()
        ->assertJsonPath('data.id', $userId);

    $this->getJson("/api/users/{$userId}/edit")
        ->assertOk()
        ->assertJsonPath('meta.mode', 'edit');

    $this->putJson("/api/users/{$userId}", [
        'name' => 'Updated User',
        'email' => 'updated@example.com',
        'password' => '',
        'password_confirmation' => '',
    ])
        ->assertOk()
        ->assertJsonPath('data.name', 'Updated User');

    $this->deleteJson("/api/users/{$userId}")
        ->assertOk();

    $this->assertDatabaseMissing('users', [
        'id' => $userId,
    ]);
});

it('validates unique emails when updating through the shared user form request', function (): void {
    $first = User::factory()->create();
    $second = User::factory()->create();

    $this->putJson("/api/users/{$second->id}", [
        'name' => $second->name,
        'email' => $first->email,
        'password' => '',
        'password_confirmation' => '',
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
});
