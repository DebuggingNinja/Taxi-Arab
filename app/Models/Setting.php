<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Class Setting
 *
 * @property int $id
 * @property string $key_name
 * @property string|null $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'key_name',
        'value'
    ];

    /**
     * Scope a query to search by key_name.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $keyName
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByKey($query, $keyName)
    {
        return $query->where('key_name', $keyName)->first();
    }

    /**
     * Get all settings and cache them for 60 minutes.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getAllSettings()
    {
        return Cache::remember('settings', 3600, function () {
            return self::all();
        });
    }
}