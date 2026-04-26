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
        $listings = Listings::with(['user', 'car.images'])->latest()->get();

        return ListingsResource::collection($listings);
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