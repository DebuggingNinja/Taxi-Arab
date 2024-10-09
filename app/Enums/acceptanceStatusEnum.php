<?php

namespace App\Enums;

use ReflectionClass;

class acceptanceStatusEnum
{
    const ACCEPTED = 'accepted';
    const REJECTED = 'rejected';
    const PENDING = 'pending';



    public static function getConstants()
    {
        $reflectionClass = new ReflectionClass(__CLASS__);
        return $reflectionClass->getConstants();
    }
}
