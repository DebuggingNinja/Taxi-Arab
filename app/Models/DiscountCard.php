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
class DiscountCard extends Model
{
    protected $table = 'discount_cards';

    protected $casts = [
        'allow_user_to_reuse' => 'boolean',
        'percentage_amount' => 'float',
        'valid_from' => 'date',
        'valid_to' => 'date',
        'charge_count' => 'int',
        'repeat_limit' => 'int',
    ];

    protected $dates = ['valid_from', 'valid_to'];
    protected $fillable = [
        'percentage_amount',
        'card_number',
        'valid_from',
        'valid_to',
        'repeat_limit',
        'charge_count',
        'allow_user_to_reuse',
    ];

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'creator_id');
    }

    public function rides()
    {
        return $this->hasMany(Ride::class, 'discount_card_id');
    }

}
