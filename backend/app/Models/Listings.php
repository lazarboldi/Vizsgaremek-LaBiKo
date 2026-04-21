<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listings extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'price',
        'status',
    ];

    /**
     * Get the user that owns the listing.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the users who have favourited this listing.
     */
    public function favouritedBy()
    {
        return $this->belongsToMany(User::class, 'favourites', 'listing_id', 'user_id')->withTimestamps();
    }
}
