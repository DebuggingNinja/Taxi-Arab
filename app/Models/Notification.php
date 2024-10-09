<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 *
 * @property int $id
 * @property string|null $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Driver[] $drivers
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notifications';

	protected $fillable = [
        'id',
        'title',
		'content',
        'image',
        'target'
	];

	public function drivers()
	{
		return $this->belongsToMany(Driver::class, 'notification_drivers')
					->withPivot('id', 'is_read')
					->withTimestamps();
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'notification_users')
					->withPivot('id', 'is_read')
					->withTimestamps();
	}
}
