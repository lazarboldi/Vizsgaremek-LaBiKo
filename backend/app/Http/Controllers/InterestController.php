<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInterestRequest;
use App\Http\Requests\UpdateInterestRequest;
use App\Http\Resources\Interest as InterestResource;
use App\Models\Interest;

class InterestController extends Controller
{
    /**
     * Display a listing of the resource.
     * Returns sent and received interests for the authenticated user.
     */
    public function index()
    {
        $user = auth()->user();
        
        $sentInterests = $user->sentInterests()
            ->with(['receiver', 'listing.car', 'listing.user'])
            ->get();
        
        $receivedInterests = $user->receivedInterests()
            ->with(['sender', 'listing.car', 'listing.user'])
            ->get();
        
        return response()->json([
            'sentInterests' => InterestResource::collection($sentInterests),
            'receivedInterests' => InterestResource::collection($receivedInterests),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInterestRequest $request)
    {
        $interest = Interest::create([
            'email' => $request->validated()['email'],
            'sender_id' => auth()->id(),
            'receiver_id' => $request->validated()['receiver_id'],
            'listing_id' => $request->validated()['listing_id'],
        ]);
        
        return new InterestResource($interest->load(['sender', 'receiver', 'listing.car', 'listing.user']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Interest $interest)
    {
        return new InterestResource($interest->load(['sender', 'receiver', 'listing.car', 'listing.user']));
    }

    /**
     * Update the specified resource in storage.
     * Only the user who created the interest can update it.
     */
    public function update(UpdateInterestRequest $request, Interest $interest)
    {
        $this->authorize('update', $interest);
        
        $interest->update($request->validated());
        
        return new InterestResource($interest->load(['sender', 'receiver', 'listing.car', 'listing.user']));
    }

    /**
     * Remove the specified resource from storage.
     * Only the user who created the interest can delete it.
     */
    public function destroy(Interest $interest)
    {
        $this->authorize('delete', $interest);
        
        $interest->delete();
        
        return response()->noContent();
    }
}
