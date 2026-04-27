<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListingsResource;
use App\Models\Listings;
use Illuminate\Support\Facades\DB;

class AdminListingController extends Controller
{
    /**
     * Display a listing of all advertisements for admin users.
     */
    public function index()
    {
        $listings = Listings::with(['user', 'car.images'])
            ->orderByRaw("status = 'pending' DESC")
            ->latest()
            ->get();

        return ListingsResource::collection($listings);
    }

    /**
     * Approve a pending advertisement as admin.
     */
    public function approve(Listings $listing)
    {
        if ($listing->status !== 'pending') {
            return response()->json([
                'message' => 'Csak jóváhagyásra váró hirdetés hagyható jóvá.'
            ], 422);
        }

        $listing->update([
            'status' => 'active',
        ]);

        return new ListingsResource($listing->load(['user', 'car.images']));
    }

    /**
     * Remove an advertisement as admin.
     */
    public function destroy(Listings $listing)
    {
        DB::transaction(function () use ($listing): void {
            $listing->favouritedBy()->detach();

            $car = $listing->car;

            $listing->delete();

            if ($car) {
                $car->delete();
            }
        });

        return response()->noContent();
    }
}