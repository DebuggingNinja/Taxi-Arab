<?php

namespace App\Services;

use App\Models\Zone;
use Illuminate\Support\Facades\Cache;

/**
 * Class ZoneService
 * @package App\Services
 */
class ZoneService
{
    /**
     * Get all zones as arrays from the database and cache the result.
     *
     * @return array
     */
    public static function getAllZonesToArray()
    {
        return Cache::remember('available_zones', 60, function () {
            return Zone::all('polygon')->pluck('polygon');
        });
    }

    /**
     * Check if a point is inside any of the given polygons.
     *
     * @param array $point The point to check [latitude, longitude].
     * @param array $zonesPloygons The array of zones as polygons.
     * @return bool True if the point is inside any zone, false otherwise.
     */
    public function AvailableLocation($location = [
        0, 0
    ]): bool
    {
        $zones = self::getAllZonesToArray();
        return $this->pointInZones($location, $zones);
    }

    /**
     * Check if a point is inside a polygon.
     *
     * @param array $point The point to check [latitude, longitude].
     * @param array $polygon The polygon as an array of points.
     * @return bool True if the point is inside the polygon, false otherwise.
     */
    function pointInZones($point, $zonesPloygons)
    {
        //Polygons
        foreach ($zonesPloygons as $polygon)
            if ($this->pointInPolygon($point, $polygon))
                return true;
        return false;
    }

    // Function to check if a point is inside a polygon
    function pointInPolygon($point, $polygon)
    {
        $xPointToCheck = $point[0];
        $yPointToCheck = $point[1];

        $isInside = false;
        $verticesCount = count($polygon);

        for ($currentVertex = 0, $previousVertex = $verticesCount - 1; $currentVertex < $verticesCount; $previousVertex = $currentVertex++) {
            $xCurrentVertex = $polygon[$currentVertex][0];
            $yCurrentVertex = $polygon[$currentVertex][1];
            $xPreviousVertex = $polygon[$previousVertex][0];
            $yPreviousVertex = $polygon[$previousVertex][1];

            $doesIntersect = (($yCurrentVertex > $yPointToCheck) != ($yPreviousVertex > $yPointToCheck)) &&
                ($xPointToCheck < ($xPreviousVertex - $xCurrentVertex) * ($yPointToCheck - $yCurrentVertex) / ($yPreviousVertex - $yCurrentVertex) + $xCurrentVertex);

            if ($doesIntersect) {
                $isInside = true;
                break;
            }
        }

        return $isInside;
    }
}
