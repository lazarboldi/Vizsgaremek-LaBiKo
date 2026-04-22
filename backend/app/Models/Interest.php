<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $fillable = [
        'email',
        'sender_id',
        'receiver_id',
        'listing_id',
    ];

    /**
     * Get the user who sent the interest
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the user who received the interest
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Get the listing related to this interest
     */
    public function listing()
    {
        return $this->belongsTo(Listings::class, 'listing_id');
    }
}
