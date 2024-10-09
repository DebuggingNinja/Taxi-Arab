<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;

class ArrayValidator
{
    public static function valid(array $data, array $rules)
    {
        $validator = Validator::make($data, $rules);
        return !$validator->fails();
    }
}
