<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

/**
 * Class User
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone_number
 * @property string|null $gender
 * @property string|null $otp
 * @property int|null $points
 * @property int|null $latest_location_id
 * @property string|null $profile_image
 * @property bool|null $is_verified
 * @property bool|null $is_blocked
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Location|null $location
 * @property Collection|Card[] $cards
 * @property Collection|Complaint[] $complaints
 * @property Collection|Notification[] $notifications
 * @property Collection|Ride[] $rides
 * @property Collection|UserAddress[] $user_addresses
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';

    protected $casts = [
        'points' => 'int',
        'latest_location_id' => 'int',
        'is_verified' => 'bool',
        'is_blocked' => 'bool',
        'is_deleted' => 'bool',
        'is_android' => 'bool'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'name',
        'phone_number',
        'gender',
        'otp',
        'points',
        'latest_location_id',
        'profile_image',
        'is_verified',
        'is_blocked',
        'remember_token',
        'password',
        'otp_attempts',
        'otp_blocked_until',
        'otp_expiration_date',
        'language',
        'active_ride_id',
        'current_credit_amount',

        'is_deleted',
        'account_phone_number',
        'device_token',

        'discount_card_id',
        'is_android',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
    public function location()
    {
        return $this->belongsTo(Location::class, 'latest_location_id');
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_users')
            ->withPivot('id', 'is_read')
            ->withTimestamps();
    }

    public function rides()
    {
        return $this->hasMany(Ride::class);
    }

    public function user_addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function active_ride()
    {
        return $this->hasOne(Ride::class, 'active_ride_id');
    }


    public function active_ride_()
    {
        return $this->hasOne(Ride::class, 'id', 'active_ride_id');
    }

    public function accessTokenChecker($token)
    {
        dd($this->currentAccessToken());
        return $this->accessToken == $token;
    }
    public function scopeendRide($query)
    {
        return $query->update(['active_ride_id' => null]);
    }
    public function scopesetBlackListed($query)
    {
        return $query->update(['is_blocked' => true]);
    }


    public function rating()
    {
        return $this->hasMany(UserRating::class, 'user_id');
    }

    public function getPhoneNumberAttribute($value)
    {
        return ($value[0] ?? false) === '0' ? $value : "0" . $value;
    }

    public function scopeFilters($query, $request)
    {
        $blocked  = $request->blocked;

        if (isset($blocked) && $blocked == 1)
            $query->where('is_blocked', 1);

        if (isset($blocked) && $blocked == 0)
            $query->where(function ($query) {
                $query->where('is_blocked', null)->orWhere('is_blocked', 0);
            });

        $search = $request->search;
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('phone_number', 'LIKE', "%$search%");
            });
        }
    }
}
