<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRating extends Model
{
    use HasFactory;
    // protected $table = 'user_ratings';

    protected $fillable = [
        'ride_id', 'user_id', 'driver_id', 'rate', 'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id');
    }
}
