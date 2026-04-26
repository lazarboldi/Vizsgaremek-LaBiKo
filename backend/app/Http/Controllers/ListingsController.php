<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListingsRequest;
use App\Http\Requests\UpdateListingsRequest;
use App\Http\Resources\ListingsResource;
use App\Models\Listings;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ListingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listings = Listings::with('user', 'car.images')->get();
        return ListingsResource::collection($listings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListingsRequest $request)
    {
        $userId = Auth::id() ?? Auth::guard('sanctum')->id();

        if (!$userId) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $listing = Listings::create([
            'user_id' => $userId,
            'car_id' => $request->validated('car_id'),
            'price' => $request->validated('price'),
            'horsepower' => $request->validated('horsepower'),
            'status' => $request->validated('status') ?? 'active',
        ]);
        return new ListingsResource($listing->load(['user', 'car.images']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Listings $listings)
    {
        return new ListingsResource($listings->load(['user', 'car.images', 'favouritedBy']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingsRequest $request, Listings $listings)
    {
        $listings->update($request->validated());
        return new ListingsResource($listings->load(['user', 'car.images']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listings $listings)
    {
        $user = Auth::guard('sanctum')->user() ?? Auth::user();

        if (!$user instanceof User) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        if (!$user->isAdmin() && (int) $listings->user_id !== (int) $user->id) {
            return response()->json([
                'message' => 'Forbidden.'
            ], 403);
        }

        $listings->delete();
        return response()->noContent();
    }
}

