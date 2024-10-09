<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverChargeLog extends Model
{
    protected $table = 'driver_charge_logs';

    protected $casts = [
        'amount' => 'float',
    ];

    protected $fillable = [
        'driver_id',
        'admin_id',
        'amount',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

}
