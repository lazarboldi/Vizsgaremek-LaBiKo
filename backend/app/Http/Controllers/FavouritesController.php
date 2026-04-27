<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListingsResource;
use App\Models\Listings;
use App\Models\User;
use Illuminate\Http\Request;

class FavouritesController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user instanceof User) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $favourites = $user
            ->favourites()
            ->with(['user', 'car.images'])
            ->latest('favourites.created_at')
            ->get();

        return ListingsResource::collection($favourites);
    }

    public function store(Request $request, Listings $listing)
    {
        $user = $request->user();

        if (!$user instanceof User) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $user->favourites()->syncWithoutDetaching([$listing->id]);

        return response()->json([
            'message' => 'A hirdetés hozzáadva a gyűjteményhez.'
        ], 201);
    }

    public function destroy(Request $request, Listings $listing)
    {
        $user = $request->user();

        if (!$user instanceof User) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $user->favourites()->detach($listing->id);

        return response()->noContent();
    }
}
