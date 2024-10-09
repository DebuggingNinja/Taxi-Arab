<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarTypeSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'car_type_id',
        'key_name',
        'value',
    ];

    public function car_type()
    {
        return $this->belongsTo(CarType::class);
    }
}