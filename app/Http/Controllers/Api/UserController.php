<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(UserFormRequest $request): JsonResponse
    {
        $user = User::query()->create($request->validated());

        return response()->json([
            'message' => 'User created successfully.',
            'data' => $user->only(['id', 'name', 'email']),
        ], 201);
    }

    public function update(UserFormRequest $request, User $user): JsonResponse
    {
        $attributes = $request->safe()->except(['password']);

        if ($request->filled('password')) {
            $attributes['password'] = $request->string('password')->toString();
        }

        $user->update($attributes);

        return response()->json([
            'message' => 'User updated successfully.',
            'data' => $user->only(['id', 'name', 'email']),
        ]);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully.',
        ]);
    }
}
