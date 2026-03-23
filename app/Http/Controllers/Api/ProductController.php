<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductFullResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $attributes = $this->validated($request);
        $attributes['slug'] = $attributes['slug'] ?? Str::slug($attributes['name']);

        $product = Product::query()->create($attributes);

        return response()->json([
            'message' => 'Product created successfully.',
            'data' => ProductFullResource::make($product->load('images'))->resolve(),
        ], 201);
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $attributes = $this->validated($request, $product);
        $attributes['slug'] = $attributes['slug'] ?? $product->slug;

        $product->update($attributes);

        return response()->json([
            'message' => 'Product updated successfully.',
            'data' => ProductFullResource::make($product->fresh()->load('images'))->resolve(),
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully.',
        ]);
    }

    protected function validated(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($product?->id),
            ],
            'base_price' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
        ]);
    }
}
