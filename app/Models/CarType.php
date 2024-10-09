<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    protected $with = ['settings'];
    protected $fillable = [
        'name', 'price_factor', 'icon', 'enabled', 'is_female_type'
    ];

    public function drivers()
    {
        return $this->hasManyThrough(Driver::class, DriverCarType::class, 'driver_id', 'id', 'id', 'car_type_id');
    }

    public function driver_car_types()
    {
        return $this->hasMany(DriverCarType::class, 'car_type_id');
    }

    /**
     * Relationship to get the settings associated with this car type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function settings()
    {
        return $this->hasMany(CarTypeSetting::class, 'car_type_id');
    }
    /**
     * Scope to search car types based on the given criteria.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $searchQuery
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $searchQuery)
    {
        return $query->where('name', 'like', "%$searchQuery%")
            ->orWhere('price_factor', 'like', "%$searchQuery%")
            ->orWhere('enabled', $searchQuery === 'enabled');
    }

    /**
     * Scope to retrieve only enabled cars.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    /**
     * Scope to retrieve only female cars.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFemaleMod($query)
    {
        return $query->where('is_female_type', true);
    }

    /**
     * Scope to retrieve only male cars.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMaleMod($query)
    {
        return $query->where('is_female_type', false);
    }

    /**
     * Disable the car type.
     *
     * @return void
     */
    public function Activate()
    {
        $this->update(['enabled' => false]);
    }

    /**
     * Enable the car type.
     *
     * @return void
     */
    public function Deactivate()
    {
        $this->update(['enabled' => true]);
    }
}
