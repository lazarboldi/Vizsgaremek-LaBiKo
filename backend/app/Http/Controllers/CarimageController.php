<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarimageRequest;
use App\Models\Carimage;
use Illuminate\Support\Facades\Storage;

class CarimageController extends Controller
{
    public function store(StoreCarimageRequest $request)
    {
        $validated = $request->validated();
        
        // file feltöltés
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
            
            $carimage = Carimage::create([
                'car_id' => $validated['car_id'],
                'image_url' => Storage::url($imagePath)
            ]);
            
            return response()->json($carimage, 201);
        }
        
        return response()->json(['error' => 'No image provided'], 400);
    }

    public function destroy(Carimage $carimage)
    {
        // törlés a storage-ból
        if ($carimage->image_url) {
            $path = str_replace('/storage/', '', $carimage->image_url);
            Storage::disk('public')->delete($path);
        }
        
        $carimage->delete();
        return response()->noContent();
    }
}
