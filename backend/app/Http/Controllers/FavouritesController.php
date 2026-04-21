<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavouritesRequest;
use App\Http\Requests\UpdateFavouritesRequest;
use App\Models\Favourites;

class FavouritesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFavouritesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Favourites $favourites)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFavouritesRequest $request, Favourites $favourites)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favourites $favourites)
    {
        //
    }
}
