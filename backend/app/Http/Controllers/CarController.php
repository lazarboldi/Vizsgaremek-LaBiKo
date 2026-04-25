<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;

class CarController extends Controller
{

    public function index()
    {
        return CarResource::collection(
            Car::with('images')->get()
        );
    }

    public function store(StoreCarRequest $request)
    {
        $car = Car::create($request->validated());

        return new CarResource(
            $car->load('images')
        );
    }


    public function show(Car $car)
    {
        return new CarResource(
            $car->load('images')
        );
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update($request->validated());

        return new CarResource(
            $car->load('images')
        );
    }

    public function destroy(Car $car)
    {
        $car->delete();

        return response()->noContent();
    }
}