<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Card
 *
 * @property int $id
 * @property string|null $category
 * @property float|null $amount
 * @property string|null $card_number
 * @property int|null $user_id
 * @property int|null $driver_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Driver|null $driver
 *
 * @package App\Models
 */
class Card extends Model
{
    protected $table = 'cards';

    protected $casts = [
        'amount' => 'float',
        'creator_id' => 'int',
        'user_id' => 'int',
        'driver_id' => 'int',
        'used_at' => 'datetime'
    ];
    protected $dates = ['used_at'];
    protected $fillable = [
        'category',
        'amount',
        'card_number',
        'user_id',
        'driver_id',
        'creator_id',
        'used_at'
    ];

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'creator_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
