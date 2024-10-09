<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Location
 * 
 * @property int $id
 * @property float|null $latitude
 * @property float|null $longitude
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Driver[] $drivers
 * @property Collection|Ride[] $rides
 * @property Collection|UserAddress[] $user_addresses
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Location extends Model
{
	protected $table = 'locations';

	protected $casts = [
		'latitude' => 'float',
		'longitude' => 'float'
	];

	protected $fillable = [
		'latitude',
		'longitude'
	];

	public function drivers()
	{
		return $this->hasMany(Driver::class, 'latest_location_id');
	}

	public function rides()
	{
		return $this->hasMany(Ride::class, 'dropoff_location_id');
	}

	public function user_addresses()
	{
		return $this->hasMany(UserAddress::class);
	}

	public function users()
	{
		return $this->hasMany(User::class, 'latest_location_id');
	}
}
