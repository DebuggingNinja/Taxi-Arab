<?php
// SetCreatedAtToNull.php

namespace App\Traits;

use Modules\User\Entities\User;

trait UserMetadata
{


    protected static function bootUserMetadata()
    {
        static::creating(function ($model) {
            $model->created_by = auth()->user()->username;
        });

        static::saving(function ($model) {
            //if ($model->deleted_at == null) $model->deleted_by = null;
            $model->updated_by = auth()->user()->username;
        });

        static::deleting(function ($model) {
            $model->deleted_by = auth()->user()->username;
            $model->save(); // Save the model to persist the deleted_by value
        });
    }



    public function _deleted_by()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'username');
    }
    public function _updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by', 'username');
    }
    public function _created_by()
    {
        return $this->belongsTo(User::class, 'created_by', 'username');
    }
}
