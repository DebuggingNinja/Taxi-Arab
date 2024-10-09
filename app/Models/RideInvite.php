<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideInvite extends Model
{
    protected $dates = [
        'expired_at'
    ];
    protected $fillable = [
        'ride_id', 'driver_id', 'status', 'expired_at',
    ];

    // Define relationships if needed

    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function scopeexpire($query)
    {
        return $query->update(['status' => 'expired']);
    }
}
