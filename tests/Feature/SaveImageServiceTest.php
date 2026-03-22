<?php

use App\Models\Product;
use App\Models\User;
use App\Services\SaveImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('stores an uploaded image for a user imageable model', function (): void {
    Storage::fake('public');
    $user = User::factory()->create();
    $file = UploadedFile::fake()->image('avatar.jpg');

    $image = app(SaveImageService::class)->handle($user, $file, [
        'alt_text' => 'Profile photo',
        'sort_order' => 1,
    ]);

    expect($image->imageable_type)->toBe(User::class)
        ->and($image->imageable_id)->toBe($user->id)
        ->and($image->alt_text)->toBe('Profile photo')
        ->and($image->sort_order)->toBe(1)
        ->and($image->img_url)->toContain('/storage/images/users/'.$user->id.'/');

    Storage::disk('public')->assertExists('images/users/'.$user->id.'/'.$file->hashName());
});

it('stores an uploaded image for a product imageable model', function (): void {
    Storage::fake('public');
    $product = Product::factory()->create();
    $file = UploadedFile::fake()->image('product.jpg');

    $image = app(SaveImageService::class)->handle($product, $file);

    expect($image->imageable_type)->toBe(Product::class)
        ->and($image->imageable_id)->toBe($product->id)
        ->and($image->img_url)->toContain('/storage/images/products/'.$product->id.'/');

    Storage::disk('public')->assertExists('images/products/'.$product->id.'/'.$file->hashName());
});
