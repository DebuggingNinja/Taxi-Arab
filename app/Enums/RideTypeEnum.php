<?php
// app/Enums/ColorsEnum.php
// app/Enums/ColorsEnum.php

namespace App\Enums;

use ReflectionClass;

class RideTypeEnum
{
    const ALL = 'All';
    const FEMALE = 'Female';


    public static function getConstants()
    {
        $reflectionClass = new ReflectionClass(__CLASS__);
        return $reflectionClass->getConstants();
    }
}
