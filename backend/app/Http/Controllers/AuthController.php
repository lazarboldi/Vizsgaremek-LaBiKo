<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function authenticate(LoginRequest $request)
    {
        $data = $request->validated();
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken('app');
            $user = $request->user();

            return response()->json([
                'data' => [
                    'token' => $token->plainTextToken,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role,
                    ],
                ]
            ]);
        } else {
            return response()->json([
                'data' => [
                    'message' => 'Sikertelen bejelentkezés!'
                ]
            ], 401);
        }
    }
}
