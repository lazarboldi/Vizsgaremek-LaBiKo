<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListingsRequest;
use App\Http\Requests\UpdateListingsRequest;
use App\Http\Resources\ListingsResource;
use App\Models\Listings;

class ListingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listings = Listings::with('user', 'car')->get();
        return ListingsResource::collection($listings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListingsRequest $request)
    {
        $userId = auth()->id() ?? auth('sanctum')->id();

        if (!$userId) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $listing = Listings::create([
            'user_id' => $userId,
            'car_id' => $request->validated('car_id'),
            'price' => $request->validated('price'),
            'status' => $request->validated('status') ?? 'active',
        ]);
        return new ListingsResource($listing->load(['user', 'car']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Listings $listings)
    {
        return new ListingsResource($listings->load(['user', 'car', 'favouritedBy']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingsRequest $request, Listings $listings)
    {
        $listings->update($request->validated());
        return new ListingsResource($listings->load(['user', 'car']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listings $listings)
    {
        $listings->delete();
        return response()->noContent();
    }
}

