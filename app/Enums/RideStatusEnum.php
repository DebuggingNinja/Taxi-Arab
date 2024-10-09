<?php
// app/Enums/ColorsEnum.php
// app/Enums/ColorsEnum.php

namespace App\Enums;

use ReflectionClass;

class RideStatusEnum
{
    const PENDING = 'pending';
    const ACCEPTED = 'accepted';
    const AT_PICKUP = 'at_pickup';
    const ONGOING = 'ongoing';
    const COMPLETED = 'completed';
    const CANCELLED = 'cancelled';

    public static function getConstants()
    {
        $reflectionClass = new ReflectionClass(__CLASS__);
        return $reflectionClass->getConstants();
    }
}
