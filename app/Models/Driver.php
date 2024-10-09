<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class Driver
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone_number
 * @property string|null $gender
 * @property string|null $otp
 * @property string|null $national_id
 * @property string|null $vehicle_registration_plate
 * @property string|null $vehicle_manufacture_date
 * @property string|null $vehicle_color
 * @property string|null $vehicle_model
 * @property string|null $vehicle_image
 * @property string|null $vehicle_license_image
 * @property string|null $personal_image
 * @property string|null $personal_license_image
 * @property string|null $personal_identification_card_image
 * @property string|null $personal_criminal_records_certificate_image
 * @property float|null $current_credit_amount
 * @property bool|null $accepting_rides
 * @property int|null $latest_location_id
 * @property string|null $acceptance_status
 * @property bool|null $is_verified
 * @property bool|null $is_blocked
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Location|null $location
 * @property Collection|Card[] $cards
 * @property Collection|Complaint[] $complaints
 * @property Collection|Notification[] $notifications
 * @property Collection|Ride[] $rides
 *
 * @package App\Models
 */
class Driver extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'drivers';
    protected $with = ['location', 'car_type'];
    protected $casts = [
        'current_credit_amount' => 'float',
        'accepting_rides' => 'bool',
        'latest_location_id' => 'int',
        'is_asset' => 'bool',
        'is_verified' => 'bool',
        'is_deleted' => 'bool',
        'is_blocked' => 'bool',
        'is_android' => 'bool'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $fillable = [
        'name',
        'phone_number',
        'gender',
        'otp',
        'national_id',
        'vehicle_registration_plate',
        'vehicle_manufacture_date',
        'vehicle_color',
        'vehicle_model',
        'vehicle_image',
        'vehicle_license_image',
        'personal_image',
        'personal_license_image',
        'personal_identification_card_image',
        'personal_criminal_records_certificate_image',
        'current_credit_amount',
        'accepting_rides',
        'latest_location_id',
        'acceptance_status',
        'is_verified',
        'is_blocked',
        'otp_attempts',
        'otp_blocked_until',
        'otp_expiration_date',
        'car_type_id',
        'active_ride_id',
        'is_asset',
        'is_deleted',
        'account_phone_number',
        'device_token',
        'is_android',
    ];

    public function invites()
    {
        return $this->hasMany(RideInvite::class, 'driver_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'latest_location_id');
    }
    public function car_type()
    {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }

    public function car_types()
    {
        return $this->hasManyThrough(CarType::class, DriverCarType::class, 'car_type_id', 'id', 'id', 'driver_id');
    }

    public function driver_car_types()
    {
        return $this->hasMany(DriverCarType::class, 'driver_id');
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function charges()
    {
        return $this->hasMany(DriverChargeLog::class, 'driver_id');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_drivers')
            ->withPivot('id', 'is_read')
            ->withTimestamps();
    }

    public function rides()
    {
        return $this->hasMany(Ride::class);
    }

    public function active_ride()
    {
        return $this->belongsTo(Ride::class, 'active_ride_id');
    }

    public function scopeAvailableForRide($query)
    {
        return $query->whereNull('active_ride_id')
            ->where('is_verified', true)
            ->where('is_blocked', false)
            ->where('current_credit_amount', '>=', 0)
            ->where('accepting_rides', true);
    }
    // Methods
    public function accessTokenChecker($token)
    {
        dd($this->currentAccessToken());
        return $this->accessToken == $token;
    }
    public function scopeendRide($query, $appTax = null)
    {
        if ($appTax) return $query->update(['active_ride_id' => null, 'current_credit_amount' => DB::raw('current_credit_amount - ' . $appTax)]);

        return $query->update(['active_ride_id' => null]);
    }
    public function ratings()
    {
        return $this->hasMany(DriverRating::class, 'driver_id');
    }
    public function AverageRating()
    {
        // Use the remember method to cache the result for 24 hours (adjust as needed)
        return Cache::remember('average_rating_driver_' . $this->id, 3600, function () {
            // Calculate the average rating if not found in the cache
            return $this->ratings->avg('rate');
        });
    }

    public function RidesCount()
    {
        // Use the remember method to cache the result for 24 hours (adjust as needed)
        return Cache::remember('rides_count_driver_' . $this->id, 3600, function () {
            // Calculate the average rating if not found in the cache
            return $this->rides->count();
        });
    }
    public function scopesetBlackListed($query)
    {
        return $query->update(['is_blocked' => true]);
    }

    public function getPhoneNumberAttribute($value)
    {
        return ($value[0] ?? false) === '0' ? $value : "0" . $value;
    }

    public function scopeFilters($query, $request)
    {
        $gender = $request->gender;
        if ($gender) {
            if ($gender == 'Male') $query->where('gender', 'Male');
            if ($gender == 'Female') $query->where('gender', 'Female');
        }

        $acceptance = $request->acceptance;
        if ($acceptance) {
            if ($acceptance == 'pending') $query->where('acceptance_status', 'pending');
            if ($acceptance == 'rejected') $query->where('acceptance_status', 'rejected');
            if ($acceptance == 'accepted') $query->where('acceptance_status', 'accepted');
        }
        $blocked  = $request->blocked;

        if (isset($blocked) && $blocked == 1)
            $query->where('is_blocked', 1);

        if (isset($blocked) && $blocked == 0)
            $query->where(function ($query) {
                $query->where('is_blocked', null)->orWhere('is_blocked', 0);
            });
        $search = $request->search;
        if ($search)
            $query->where(function ($query) use ($search) {
                $query->orWhere('name', 'LIKE', "%$search%")
                    ->orWhere('phone_number', 'LIKE', "%$search%")
                    ->orWhere('national_id', 'LIKE', "%$search%")
                    ->orWhere('vehicle_registration_plate', 'LIKE', "%$search%")
                    ->orWhere('vehicle_color', 'LIKE', "%$search%");
            });
    }
}
