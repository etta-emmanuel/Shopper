<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductFullResource;
use App\Http\Resources\ProductLightResource;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class ShopController extends Controller
{
    public function index(): Response
    {
        $products = Product::query()
            ->with('images')
            ->latest()
            ->get();

        return Inertia::render('ProductsIndex', [
            'products' => ProductLightResource::collection($products)->resolve(),
        ]);
    }

    public function show(Product $product): Response
    {
        $product->load('images');

        return Inertia::render('ProductsIndex', [
            'featuredProduct' => ProductFullResource::make($product)->resolve(),
            'products' => [],
        ]);
    }
}
