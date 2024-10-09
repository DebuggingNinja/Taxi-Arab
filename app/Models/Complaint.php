<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Complaint
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $driver_id
 * @property string|null $content
 * @property bool|null $is_resolved
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Driver|null $driver
 *
 * @package App\Models
 */
class Complaint extends Model
{
	protected $table = 'complaints';

	protected $casts = [
		'user_id' => 'int',
		'driver_id' => 'int',
		'is_resolved' => 'bool'
	];

	protected $fillable = [
		'user_id',
		'driver_id',
		'content',
		'email',
		'name',
		'is_resolved'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function driver()
	{
		return $this->belongsTo(Driver::class);
	}
}
