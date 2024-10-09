<?php
// app/Enums/ColorsEnum.php
// app/Enums/ColorsEnum.php

namespace App\Enums;

use ReflectionClass;

class ColorsEnum
{
    const BLACK = 'Black';
    const WHITE = 'White';
    const SILVER = 'Silver';
    const GRAY = 'Gray';
    const BLUE = 'Blue';
    const RED = 'Red';
    const GREEN = 'Green';
    const BROWN = 'Brown';
    const BEIGE = 'Beige';
    const YELLOW = 'Yellow';
    const ORANGE = 'Orange';
    const GOLD = 'Gold';
    const BRONZE = 'Bronze';
    const MAROON = 'Maroon';
    const CHARCOAL = 'Charcoal';
    const NAVY = 'Navy';
    const DARK_GREEN = 'Dark Green';
    const DARK_BLUE = 'Dark Blue';
    const DARK_GRAY = 'Dark Gray';
    const LIGHT_BLUE = 'Light Blue';
    const LIGHT_GRAY = 'Light Gray';
    const LIGHT_GREEN = 'Light Green';
    const LIGHT_BROWN = 'Light Brown';
    const LIGHT_YELLOW = 'Light Yellow';
    const LIGHT_ORANGE = 'Light Orange';
    const LIGHT_PURPLE = 'Light Purple';
    const LIGHT_PINK = 'Light Pink';
    const COPPER = 'Copper';
    const CHAMPAGNE = 'Champagne';


    public static function getConstants()
    {
        $reflectionClass = new ReflectionClass(__CLASS__);
        return $reflectionClass->getConstants();
    }
}
