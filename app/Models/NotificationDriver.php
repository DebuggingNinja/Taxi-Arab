<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NotificationDriver
 * 
 * @property int $id
 * @property int|null $driver_id
 * @property int|null $notification_id
 * @property bool|null $is_read
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Driver|null $driver
 * @property Notification|null $notification
 *
 * @package App\Models
 */
class NotificationDriver extends Model
{
	protected $table = 'notification_drivers';

	protected $casts = [
		'driver_id' => 'int',
		'notification_id' => 'int',
		'is_read' => 'bool'
	];

	protected $fillable = [
		'driver_id',
		'notification_id',
		'is_read'
	];

	public function driver()
	{
		return $this->belongsTo(Driver::class);
	}

	public function notification()
	{
		return $this->belongsTo(Notification::class);
	}
}
