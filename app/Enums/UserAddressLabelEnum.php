<?php
// app/Enums/ColorsEnum.php
// app/Enums/ColorsEnum.php

namespace App\Enums;

use ReflectionClass;

class UserAddressLabelEnum
{
    const HOME = 'home';
    const WORK = 'work';
    const OTHER = 'other';

    public static function getConstants()
    {
        $reflectionClass = new ReflectionClass(__CLASS__);
        return $reflectionClass->getConstants();
    }
}
