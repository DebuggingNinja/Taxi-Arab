<?php

namespace App\Services\Ride;

use Carbon\Carbon;

/**
 * Class RideTracker
 *
 * A service class responsible for tracking ride data and calculating latency time.
 */
class RideTracker
{
    /** @var int The accumulated latency time during the ride. */
    private $latencyTime = 0;

    /** @var Carbon|null The timestamp of the previous data point during the ride. */
    private $previousTimestamp;

    /**
     * Calculates the total latency time during the ride based on ride tracking data.
     *
     * @param array $rideTracking An array of ride tracking data.
     * @return int The total latency time in seconds.
     */
    public function calculateLatencyTime($rideTracking): int
    {
        foreach ($rideTracking as $index => $row) {
            $speed = (int) $row['speed'];
            $timestamp = Carbon::parse($row['timestamp']);

            if ($this->shouldIgnoreTimestamp($timestamp)) continue;

            $timeDifference = $this->calculateTimeDifference($timestamp);

            if ($timeDifference <= 10 && $speed < getSetting('MINIMUM_SPEED_FOR_DELAY_CALCULATION') ?? 20)
                $this->latencyTime += $timeDifference;

            $this->previousTimestamp = $timestamp;
        }

        return $this->latencyTime;
    }

    /**
     * Determines whether the timestamp should be ignored based on the time difference from the previous timestamp.
     *
     * @param Carbon $timestamp The current timestamp.
     * @return bool True if the timestamp should be ignored, false otherwise.
     */
    private function shouldIgnoreTimestamp(Carbon $timestamp): bool
    {
        return $this->previousTimestamp !== null && $timestamp->diffInSeconds($this->previousTimestamp) > 10;
    }

    /**
     * Calculates the time difference in seconds between the current and previous timestamps.
     *
     * @param Carbon $timestamp The current timestamp.
     * @return int The time difference in seconds.
     */
    private function calculateTimeDifference(Carbon $timestamp): int
    {
        return $timestamp->diffInSeconds($this->previousTimestamp ?? $timestamp);
    }
}
