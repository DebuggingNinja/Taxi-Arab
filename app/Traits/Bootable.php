<?php
// SetCreatedAtToNull.php

namespace App\Traits;

use Modules\User\Entities\User;

trait Bootable
{

    public static function boot()
    {
        parent::boot();
        if (isset(self::$bootingTraits))
            foreach (self::$bootingTraits as $trait)
                parent::{"boot$trait"}();
    }
}
