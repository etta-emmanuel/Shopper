<?php

namespace App\Services;

use Illuminate\Support\Collection;

class NavService
{
    protected array $routes = [
        [
            'label' => 'Home',
            'route' => 'web.home',
            'icon' => 'bi bi-house',
            'for' => ['guest', 'web', 'admin'],
        ],
        [
            'label' => 'Shop',
            'route' => 'web.shop.index',
            'icon' => 'bi bi-shop',
            'for' => ['guest', 'web'],
        ],
        [
            'label' => 'Dashboard',
            'route' => 'web.dashboard.show',
            'icon' => 'bi bi-speedometer2',
            'for' => ['admin'],
        ],
        [
            'label' => 'Product List',
            'route' => 'web.products.index',
            'icon' => 'bi bi-shop',
            'for' => ['admin'],
        ],
        [
            'label' => 'Users',
            'route' => 'web.users.index',
            'icon' => 'bi bi-people',
            'for' => ['admin'],
        ],
    ];

    public function getRoutes(): array
    {
        $user = auth()->user();

        $role = 'guest';

        if ($user) {
            $role = method_exists($user, 'isAdmin') && $user->isAdmin() ? 'admin' : 'web';
        }

        return collect($this->routes)
            ->filter(fn ($item) => in_array($role, $item['for']))
            ->map(function ($item) {
                return [
                    'label' => $item['label'],
                    'href' => route($item['route']),
                    'icon' => $item['icon'],
                    'route' => $item['route'],
                ];
            })
            ->values()
            ->toArray();
    }
}
