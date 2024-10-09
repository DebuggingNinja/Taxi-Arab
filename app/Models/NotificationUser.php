<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NotificationUser
 * 
 * @property int $id
 * @property int|null $user_id
 * @property int|null $notification_id
 * @property bool|null $is_read
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 * @property Notification|null $notification
 *
 * @package App\Models
 */
class NotificationUser extends Model
{
	protected $table = 'notification_users';

	protected $casts = [
		'user_id' => 'int',
		'notification_id' => 'int',
		'is_read' => 'bool'
	];

	protected $fillable = [
		'user_id',
		'notification_id',
		'is_read'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function notification()
	{
		return $this->belongsTo(Notification::class);
	}
}
