<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'make',
        'brand',
        'model',
        'color',
        'description',
        'year',
        'mileage',
        'fuel_type',
        'transmission',
        'engine_size'
    ];

    public function images()
    {
        return $this->hasMany(Carimage::class, 'car_id');
    }

    public function listing()
    {
        return $this->hasOne(Listings::class, 'car_id');
    }
}