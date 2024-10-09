<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RideTracking
 *
 * @property int $id
 * @property int|null $ride_id
 * @property float|null $latitude
 * @property float|null $longitude
 * @property float|null $speed
 * @property Carbon|null $timestamp
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Ride|null $ride
 *
 * @package App\Models
 */
class RideTracking extends Model
{
    protected $table = 'ride_tracking';

    protected $casts = [
        'ride_id' => 'int',
        'latitude' => 'float',
        'longitude' => 'float',
        'speed' => 'float',
        'timestamp' => 'datetime'
    ];

    protected $fillable = [
        'ride_id',
        'latitude',
        'longitude',
        'speed',
        'timestamp',
        'is_pre_ride'
    ];

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }
}
