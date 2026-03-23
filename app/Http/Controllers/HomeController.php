<?php

namespace App\Http\Controllers;

use App\Services\NavService;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(NavService $navService): Response
    {
        return Inertia::render('Home', [
            'navItems' => $navService->getRoutes(),
            'message' => 'Run your shopper experience from one clean, fast, conversion-ready surface.',
            'date' => now()->toDayDateTimeString(),
        ]);
    }
}
