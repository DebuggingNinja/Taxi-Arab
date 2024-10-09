<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class DriverRating extends Model
{
    protected $table = 'driver_ratings';

    protected $fillable = [
        'ride_id',
        'user_id',
        'driver_id',
        'rate',
        'note',
    ];



    // Define relationships
    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
}
