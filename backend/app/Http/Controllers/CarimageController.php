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
            $publicPath = Storage::disk('public')->url($imagePath);
            
            $carimage = Carimage::create([
                'car_id' => $validated['car_id'],
                'image_url' => url($publicPath)
            ]);
            
            return response()->json($carimage, 201);
        }
        
        return response()->json(['error' => 'No image provided'], 400);
    }

    public function destroy(Carimage $carimage)
    {
        // törlés a storage-ból
        if ($carimage->image_url) {
            $urlPath = parse_url($carimage->image_url, PHP_URL_PATH) ?? $carimage->image_url;
            $path = ltrim(str_replace('/storage/', '', $urlPath), '/');
            Storage::disk('public')->delete($path);
        }
        
        $carimage->delete();
        return response()->noContent();
    }
}
