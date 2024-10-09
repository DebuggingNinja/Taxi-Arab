<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\RideStatusEnum;
use App\Enums\RideTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


/**
 * Class Ride
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $driver_id
 * @property float|null $driver_distance_from_pickup
 * @property float|null $distance
 * @property int|null $pickup_location_id
 * @property Carbon|null $pickup_datetime
 * @property int|null $dropoff_location_id
 * @property Carbon|null $dropoff_datetime
 * @property Carbon|null $expected_ride_duration
 * @property float|null $fare
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Driver|null $driver
 * @property Location|null $location
 * @property Collection|RideTracking[] $ride_trackings
 *
 * @package App\Models
 */
class Ride extends Model
{
    protected $table = 'rides';

    protected $casts = [
        'user_id'                           => 'int',
        'driver_id'                         => 'int',
        'driver_distance_from_pickup'       => 'float',
        'expected_distance'                 => 'float',
        'pickup_location_id'                => 'int',
        'pickup_datetime'                   => 'datetime',
        'dropoff_location_id'               => 'int',
        'dropoff_datetime'                  => 'datetime',
        'expected_total_fare'               => 'float',
        'actual_distance'                   => 'float',
        'actual_ride_duration'              => 'datetime',
        'expected_driver_fare'              => 'float',
        'expected_app_fare'                 => 'float',
        'actual_total_fare'                 => 'float',
        'actual_driver_fare'                => 'float',
        'actual_app_fare'                   => 'float',
        'car_type_id'                       => 'int',
        'type'                              => 'string',
        'accepted_at'                       => 'datetime',
        'driver_pickup_at'                  => 'datetime',
        'started_at'                        => 'datetime',
        'finished_at'                       => 'datetime',
        'cancelled_at'                      => 'datetime',

        'discount_card_id'                  => 'int',
        'discount_enabled'                  => 'boolean',
        'is_paid'                           => 'boolean',

        'has_balance_discount'              => 'boolean',
    ];

    protected $fillable = [
        'user_id',
        'driver_id',
        'driver_distance_from_pickup',
        'expected_distance',
        'pickup_location_id',
        'pickup_datetime',
        'pickup_location_name',
        'dropoff_location_id',
        'dropoff_datetime',
        'dropoff_location_name',

        'actual_distance',
        'actual_ride_duration',
        'actual_total_fare',
        'actual_driver_fare',
        'actual_app_fare',

        'expected_ride_duration',
        'expected_total_fare',
        'expected_driver_fare',
        'expected_app_fare',

        'driver_pickup_at',
        'driver_pickup_location_id',

        'car_type_id',
        'type',
        'status',
        'accepted_at',
        'started_at',
        'completed_at',
        'cancelled_at',

        'cancellation_reason',
        'price_before_discount',
        'discount_enabled',
        'discount_card_id',
        'is_paid',

        'has_balance_discount',
        'discounted_balance_amount',
        'cancelled_by',

        'calculation_details',
        'driver_cancellation_fees',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function discountCard()
    {
        return $this->belongsTo(DiscountCard::class, 'discount_card_id');
    }

    public function driver_pickup_location()
    {
        return $this->belongsTo(Location::class, 'driver_pickup_location_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'dropoff_location_id');
    }

    public function ride_trackings()
    {
        return $this->hasMany(RideTracking::class);
    }

    public function car_type()
    {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }

    public function _pickup_location()
    {
        return $this->belongsTo(Location::class, 'pickup_location_id');
    }

    public function _dropoff_location()
    {
        return $this->belongsTo(Location::class, 'dropoff_location_id');
    }

    public function invitations()
    {
        return $this->hasMany(RideInvite::class, 'ride_id');
    }

    // Functions
    public function matchUser($id)
    {
        return $this->user_id == $id;
    }

    public function matchDriver($id)
    {
        return $this->driver_id == $id;
    }

    public function matchDriverOrUser($id)
    {
        return $this->driver_id == $id || $this->user_id == $id;
    }

    public function scopeFilters($query, $request)
    {

        if ($request->status && in_array($request->status, RideStatusEnum::getConstants()))
            $query->where('status', $request->status);

        if ($request->type && in_array($request->type, RideTypeEnum::getConstants()))
            $query->where('type', $request->type);

        $search = $request->search;


        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('pickup_location_name', 'LIKE', "%$search%")
                    ->orWhere('dropoff_location_name', 'LIKE', "%$search%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $request = new Request();
                        $request->merge(['search' => $search]);
                        $q->filters($request);
                    })
                    ->orWhereHas('driver', function ($q) use ($search) {
                        $request = new Request();
                        $request->merge(['search' => $search]);
                        $q->filters($request);
                    });
            });
        }
    }
}
