<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Home', [
            'message' => 'Run your shopper experience from one clean, fast, conversion-ready surface.',
            'date' => now()->toDayDateTimeString(),
        ]);
    }
}
