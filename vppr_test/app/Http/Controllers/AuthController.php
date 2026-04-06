<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\AuthProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected AuthProvider $authProvider;

    public function __construct(AuthProvider $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $example;

        $result = $this->authProvider->register($request->only(['name', 'email', 'password']));

        return response()->json([
            'user' => $result['user'],
            'token' => $result['token'],
            'example' => $example,
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $token = $this->authProvider->login($request->only(['email', 'password']));

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['token' => $token]);
    }

    public function logout(): JsonResponse
    {
        $this->authProvider->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me(): JsonResponse
    {
        $user = $this->authProvider->me();

        return response()->json(['user' => $user]);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $result = $this->authProvider->resetPassword($request->only(['email', 'password']));

        if (!$result) {
            return response()->json(['error' => 'E-mail não encontrado'], 404);
        }

        return response()->json(['message' => 'Senha alterada com sucesso']);
    }
}
