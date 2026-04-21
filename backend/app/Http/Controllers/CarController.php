<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;

class CarController extends Controller
{

    public function index()
    {
        return response()->json(
            Car::with('images')->get()
        );
    }

    public function store(StoreCarRequest $request)
    {
        $car = Car::create($request->validated());

        return response()->json(
            $car->load('images'),
            201
        );
    }


    public function show(Car $car)
    {
        return response()->json(
            $car->load('images')
        );
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update($request->validated());

        return response()->json(
            $car->load('images')
        );
    }

    public function destroy(Car $car)
    {
        $car->delete();

        return response()->json(null,204);
    }
}