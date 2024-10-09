<?php

namespace App\Services\Validations;

class RequirementsValidator
{
    public static function validateRequirements($instance, $methodName)
    {
        $requirements = $instance->requirements;

        if (isset($requirements[$methodName])) {
            foreach ($requirements[$methodName] as $requiredProperty) {
                if (!$instance->{$requiredProperty}) {
                    throw new \RuntimeException("Required property '{$requiredProperty}' is not set.");
                }
            }
        }
    }
}
