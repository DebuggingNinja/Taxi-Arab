<?php
// app/Enums/ColorsEnum.php
// app/Enums/ColorsEnum.php

namespace App\Enums;

use ReflectionClass;

class RideInvitationStatusEnum
{
    const PENDING   = 'pending';
    const ACCEPTED  = 'accepted';
    const EXPIRED   = 'expired';

    public static function getConstants()
    {
        $reflectionClass = new ReflectionClass(__CLASS__);
        return $reflectionClass->getConstants();
    }
}
