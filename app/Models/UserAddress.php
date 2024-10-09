<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserAddress
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $label
 * @property string|null $address
 * @property int|null $location_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Location|null $location
 *
 * @package App\Models
 */
class UserAddress extends Model
{
    protected $table = 'user_addresses';
    protected $with = ['location'];
    protected $casts = [
        'user_id' => 'int',
        'location_id' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'label',
        'address',
        'location_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }


    /**
     * Scope a query to search for user addresses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $searchTerm
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        if ($search)
            return $query->where('address', 'like', "%$search%");
    }
}
