<?php

// app/Helpers/SettingsHelper.php

use App\Models\CarType;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('getSetting')) {
    /**
     * Get a specific setting value by key.
     *
     * @param  \App\Models\Setting  $settings
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function getSetting($key, $default = null)
    {
        $allSettings = Setting::getAllSettings();
        return $allSettings->where('key_name', $key)->first()['value'] ?? $default;
    }
}
if (!function_exists('getCarSetting')) {
    function getCarSetting($setting, $carTypeId)
    {
        //♥️
        $carType = Cache::remember('car_type_' . $carTypeId, 60, function () use ($carTypeId) {
            return CarType::find($carTypeId);
        });
        return $carType->settings->where('key_name', $setting)->first()->value ?? null;
    }
}
if (!function_exists('getModelName')) {
    /**
     * Get the model name from a given record instance.
     *
     * @param mixed $record The record instance.
     * @return string|null The model name or null if not found.
     */
    function getModelName($record)
    {
        if ($record) {
            // Use the get_class function to get the fully qualified class name
            return get_class($record);
        }

        return null;
    }
}
if (!function_exists('polygonToUrl')) {
    function polygonToUrl($polygon)
    {
        $featureCollection = [
            'type' => 'FeatureCollection',
            'features' => [
                [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Polygon',
                        'coordinates' => [array_map(fn ($point) => [$point[1], $point[0]], $polygon)]
                    ],
                    'properties' => []
                ]
            ]
        ];

        return 'https://geojson.io/#data=data:application/json,' . urlencode(json_encode($featureCollection));
    }
}

if (!function_exists('getRatio')) {
    function getRatio($num1, $num2)
    {
        try {
            return ceil($num1 / $num2);
        } catch (\Throwable $th) {
            return 0;
        }
    }
}
