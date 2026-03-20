<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $users = User::query()
            ->latest()
            ->get(['id', 'name', 'email']);

        return Inertia::render('Home', [
            'message' => 'Run your shopper experience from one clean, fast, conversion-ready surface.',
            'users' => $users,
            'date' => now()->toDayDateTimeString(),
        ]);
    }
}
