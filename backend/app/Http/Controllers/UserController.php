<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListingsResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function me(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $listings = $user->listings()->with(['user', 'car.images'])->latest()->get();

        return response()->json([
            'data' => [
                'user' => new UserResource($user),
                'listings' => ListingsResource::collection($listings),
            ],
        ]);
    }

    public function show(int $id) {
        return response()->json([
            'data' => User::findOrFail($id)
        ]);
    }
}
