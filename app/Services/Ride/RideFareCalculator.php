<?php

namespace App\Services\Ride;

use App\Models\Ride;

// سعر فتحه عداد مخصص فنوع العربيه
// سعر الكيلو مخصص لنوع العربيه
// سعر دقيقة تاخير مخصص لنوع العربيه
// اقل سعر لرحله مخصص لنوع العربيه

/**
 * الحسبه بتمشي ازاي
 * حسب نوع العربيه بيكون لينا فتحه عداد
 * بنحسب السعر حسب الكيلو بس  ونجمعهم ودا بيكون السعر المتوقع
 *
 */

/**
 * بعد الرحله
 * الحسبه بتمشي ازاي
 * السعر المتوقع + الثواني الي مشيها تحت سرعه معينه بنحسبها ونزودها عليها
 *
 */

/**
 * Class RideFareCalculator
 *
 * A service class responsible for calculating ride fares based on various factors.
 */
class RideFareCalculator
{
    /** @var float The base fare for the ride. */
    private $baseFare;

    /** @var float The fare per kilometer for the ride. */
    private $kilometerFare;

    /** @var float The fare for each late minute during the ride. */
    private $lateMinuteFare;

    /** @var float The minimum fare for the ride. */
    private $minimumFare;

    /** @var int The ID of the car type associated with the ride. */
    private $carTypeId;

    /** @var float The application tax percentage. */
    private $appTaxPercentage;

    /** @var float The rush hour fare percentage. */
    private $rushHourFare;

    /** @var float The compensation for drivers traveling more than 2 kilometers. */
    private $driver2KmCompansation;

    /** @var Ride The instance of the Ride model representing the ride. */
    private $ride;

    /**
     * Sets the ride for which the fare will be calculated.
     *
     * @param int $rideId The ID of the ride.
     * @return RideFareCalculator
     */
    public function setRide($rideId)
    {
        $this->ride = Ride::with('ride_trackings')->findOrFail($rideId);
        return $this;
    }


    /**
     * RideFareCalculator constructor.
     *
     * @param int $carTypeId The ID of the car type associated with the ride.
     */
    public function __construct($carTypeId)
    {
        $this->carTypeId                    = $carTypeId;
        $this->baseFare                     = getCarSetting('BASE_FARE', $this->carTypeId) ?? abort(400, 'Failed Fetching Car Data Code 0'); // حسب نوع العربيه
        $this->kilometerFare                = getCarSetting('KILOMETER_FARE', $this->carTypeId) ?? abort(400, 'Failed Fetching Car Data Code 1'); // حسب نوع العربيه
        $this->lateMinuteFare               = getCarSetting('LATE_MINUTE_FARE', $this->carTypeId) ?? abort(400, 'Failed Fetching Car Data Code 2'); // حسب نوع العربيه
        $this->minimumFare                  = getCarSetting('MINIMUM_FARE', $this->carTypeId) ?? abort(400, 'Failed Fetching Car Data Code 3'); // حسب نوع العربيه

        $this->driver2KmCompansation        = getSetting('DRIVER_COMPANSATION_FOR_MORE_THAN_2KM');
        $this->appTaxPercentage             = getSetting('APP_TAX_PERCENTAGE'); // نسبه عامه
        $this->rushHourFare                 = getSetting('RUSH_HOUR_FARE'); // نسبه عامه
    }

    /**
     * Applies a multiplier to each element in the given array.
     *
     * @param array $array The input array.
     * @param float $factor The multiplier factor.
     * @return array The resulting array after applying the multiplier.
     */
    public static function applyMultiplier($array, $factor)
    {
        return array_map(function ($value) use ($factor) {
            return $value * $factor;
        }, $array);
    }

    /**
     * Calculates the upfront fare for the ride based on the given distance.
     *
     * @param float $distance The distance of the ride.
     * @return array An array containing the total fare, driver's fare, and app's fare.
     */
    public function calculateUpfrontFare($distance)
    {
        $distanceFare   = $this->kilometerFare * $distance;
        $totalFare      = $this->baseFare + $distanceFare;

        if ($totalFare < $this->minimumFare) $totalFare =  $this->minimumFare;

        $appTaxPercentage   = $totalFare * $this->appTaxPercentage;
        return [
            'total_fare'    => $totalFare,
            'driver_fare'   => $totalFare - $appTaxPercentage,
            'app_fare'      => $appTaxPercentage,
            'minimumFare'   => $this->minimumFare
        ];
    }

    public function calculateFare($distance)
    {
        return $this->baseFare + ($this->kilometerFare * $distance);
    }

    /**
     * Calculates the post-trip fare for the ride, considering latency time and driver compensation.
     *
     * @return array An array containing the total fare, driver's fare, and app's fare.
     */
    public function calculatePostTripFare($distance)
    {
        // Create an instance of RideTracker
        $rideTracker            = new RideTracker();
        $rideTrackingData       = $this->ride->ride_trackings->where('is_pre_ride', false);
        $totalLatencyTime       = $rideTracker->calculateLatencyTime($rideTrackingData);
        $latencyFare            = $this->calculateLatencyFare($totalLatencyTime);
        $driver2KmCompansation  = $this->applyDriverCompansation();
        $calculatedFare         = $this->calculateFare($distance);

        $totalFare = $calculatedFare + $latencyFare + $driver2KmCompansation;

        if($totalFare < $this->minimumFare){
            $calculatedFare = $this->minimumFare - ($latencyFare + $driver2KmCompansation);
            $totalFare = $calculatedFare + $latencyFare + $driver2KmCompansation;
        }

        $appTaxPercentage = $totalFare * $this->appTaxPercentage;

        $newFare = [
            'total_fare'    => $totalFare,
            'driver_fare'   => ($calculatedFare - $appTaxPercentage) + ($latencyFare * (1 - $appTaxPercentage)) + $driver2KmCompansation,
            'app_fare'      => $appTaxPercentage,
        ];

        $this->ride->update([
            'calculation_details'   => json_encode([
                'totalLatencyTime'  => $totalLatencyTime,
                'latencyFare'       => $latencyFare,
                'driver2KmCompans'  => $driver2KmCompansation,
                'calculatedFare'    => $calculatedFare,
                'totalFare'         => $totalFare,
                'appTaxPercentage'  => $appTaxPercentage
            ]),
            'actual_total_fare'     => $newFare['total_fare'],
            'actual_driver_fare'    => $newFare['driver_fare'],
            'actual_app_fare'       => $newFare['app_fare'],
        ]);

        return $newFare;
    }

    /**
     * Applies driver compensation based on the driver's distance from the pickup location.
     *
     * @return float The driver compensation amount.
     */
    public function applyDriverCompansation()
    {
        if ($this->ride->driver_distance_from_pickup >= 2) return $this->driver2KmCompansation;
        return 0;
    }

    /**
     * Calculates the fare for latency time based on the provided extra seconds.
     *
     * @param int $extraSeconds The extra seconds representing latency time.
     * @return float The calculated latency fare.
     */
    private function calculateLatencyFare($extraSeconds)
    {
        $extraMinuts = $extraSeconds / 60;
        return $this->lateMinuteFare * $extraMinuts;
    }
}
