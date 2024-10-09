<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active',
        'polygon',
    ];

    protected $casts = [
        'polygon' => 'json',
    ];


    public function scopeFilters($query, $request)
    {

        $search = $request->search;
        if ($search)
            $query->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            });
    }
}
