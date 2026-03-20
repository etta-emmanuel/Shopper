<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $products = Product::query()
            ->with('images')
            ->latest()
            ->take(6)
            ->get();

        $users = User::query()
            ->with('images')
            ->latest()
            ->take(6)
            ->get(['id', 'name', 'email', 'created_at']);

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'products' => Product::count(),
                'users' => User::count(),
                'discountedProducts' => Product::query()->where('discount', '>', 0)->count(),
                'averageBasePrice' => Product::query()->avg('base_price') ?? 0,
            ],
            'recentProducts' => $products->map(fn (Product $product) => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'base_price' => $product->base_price,
                'discount' => $product->discount,
                'image' => $product->images->sortBy('sort_order')->first()?->img_url,
            ]),
            'recentUsers' => $users->map(fn (User $user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at?->toDayDateTimeString(),
                'image' => $user->images->sortBy('sort_order')->first()?->img_url,
            ]),
        ]);
    }
}
