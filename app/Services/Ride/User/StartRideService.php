<?php

namespace App\Services\Ride\User;

use App\Http\Resources\CarType\CarTypeCollection;
use App\Models\CarType;
use App\Models\Driver;
use App\Models\Location;
use App\Models\Ride;
use App\Models\User;
use App\Services\Firebase;
use App\Services\LocationService;
use App\Services\Ride\RideFareCalculator;
use App\Services\Validations\RequirementsValidator;
use App\Services\ZoneService;

class StartRideService
{
    public
        $pickupLocationName,
        $pickupLatitude,
        $pickupLongitude,

        $dropoffLocationName = null,
        $dropoffLatitude = null,
        $dropoffLongitude = null,

        $distance = null;

    public
        $rideType;

    public
        $carTypeId,
        $expectedRideDuration = null;
    public $locationsIds;
    public $requirements = [
        'checkLocationsInZones'             => ['pickupLatitude', 'pickupLongitude', 'dropoffLatitude', 'dropoffLongitude'],
        'generatePickupDropoffLocationsIds' => ['pickupLatitude', 'pickupLongitude', 'dropoffLatitude', 'dropoffLongitude'],
        'startRide'                         => ['carTypeId']
    ];


    public function checkLocationsInZones()
    {

        $zoneService = new ZoneService();
        return ($zoneService->AvailableLocation([$this->pickupLatitude, $this->pickupLongitude])
            && ($this->dropoffLatitude && $this->dropoffLongitude ? $zoneService->AvailableLocation([$this->dropoffLatitude, $this->dropoffLongitude]) : 1));
    }

    /**
     *
     * Inputs estimatedDistance & estimatedTime
     *
     * step 1 : Checks If the dropoff and pickup in zones. || Done
     * step 2 : Generate Price Depend on Distance
     * step 3 : Apply the price for All Car Types and return it
     *
     * Output => Price For All Car Types
     *
     */

    public function estimateRidePrices($distance = null, $female_mod = false)
    {
        if(!$distance) $distance = 1;
        $type = $female_mod ? CarType::Enabled() : CarType::Enabled()->maleMod();
        $carTypes = new CarTypeCollection($type->get());
        return $carTypes->map(function ($carType) use ($distance) {
            $fareCalculator = new RideFareCalculator($carType->id);
            $fare = $fareCalculator->calculateUpfrontFare($distance);
            return [
                'carType' => $carType,
                'fare' =>  round($fare['total_fare'], 2)
            ];
        });
    }


    public function estimateRidePriceForCarType()
    {
        $fareCalculator = new RideFareCalculator($this->carTypeId);
        return $fareCalculator->calculateUpfrontFare($this->distance);
    }
    /**
     *
     * Inputs Pickup & Dropoff & Distance & rideType & carTypeId & expectedRideDuration
     *
     * step 1 : Checks If the dropoff and pickup in zones.
     * step 2 : Generate Price Depend on Distance
     * step 3 : Apply Factor Of Ride Type
     * step 4 : Apply the price for Certain Car Type
     * step 5 : Insert into Rides Table
     * [ user_id,
     * distance,
     * pickup_location_id,
     * dropoff_location_id,
     * expected_ride_duration,
     * fare,
     * type,
     * car_type_id,
     * pickup_location_name,
     * dropoff_location_name ]
     * step 6 : Start Ride Channel.
     *
     */
    public function startRide()
    {
        if (!$this->checkLocationsInZones()) abort(400, 'Invalid locations. Please make sure the pickup and drop-off locations are within the allowed zones.');


        if (user_auth()->user()->active_ride_id != null) abort(400, 'Unable to Start a New Ride: You currently have an ongoing ride in progress.');
        $this->locationsIds = $this->generatePickupDropoffLocationsIds();
        $fares = $this->estimateRidePriceForCarType();

        $discountCard = user_auth()->user()?->discount_card_id ?? null;

        $ride =  Ride::create(
            [
                'user_id'                           => user_auth()->id(),
                'driver_id'                         => null,
                'driver_distance_from_pickup'       => null,
                'expected_distance'                 => $this->distance,

                'pickup_location_id'                => $this->locationsIds['pickupLocationId'],
                'pickup_datetime'                   => null,
                'pickup_location_name'             => $this->pickupLocationName,

                'dropoff_location_id'               => $this->locationsIds['dropoffLocationId'],
                'dropoff_datetime'                  => null,
                'dropoff_location_name'             => $this->dropoffLocationName,

                'expected_ride_duration'            => $this->expectedRideDuration,
                'expected_total_fare'               => $fares['total_fare'],
                'expected_driver_fare'              => $fares['driver_fare'],
                'expected_app_fare'                 => $fares['app_fare'],

                'actual_distance'                   => null,
                'actual_ride_duration'              => null,
                'actual_total_fare'                 => null,
                'actual_driver_fare'                => null,
                'actual_app_fare'                   => null,

                'car_type_id'                       => $this->carTypeId,
                'type'                              => $this->rideType,
                'discount_card_id'                  => $discountCard
            ]
        )->load([
            'user',
            'driver',
            'car_type',
            '_pickup_location',
            '_dropoff_location',
        ]);

        $update = ['active_ride_id' => $ride->id];
        if($discountCard) $update['discount_card_id'] = null;

        User::findOrFail(user_auth()->id())->update($update);

        return $ride;
    }

    public function generatePickupDropoffLocationsIds()
    {
        return [
            'pickupLocationId'   =>  LocationService::locate($this->pickupLatitude, $this->pickupLongitude),
            'dropoffLocationId'  =>  $this->dropoffLatitude && $this->dropoffLongitude ? LocationService::locate($this->dropoffLatitude, $this->dropoffLongitude) : null
        ];
    }

    public function setPickupLocationName($pickupLocationName)
    {
        $this->pickupLocationName = $pickupLocationName;
        return $this;
    }

    public function setPickupLatitude($pickupLatitude)
    {
        $this->pickupLatitude = $pickupLatitude;
        return $this;
    }

    public function setPickupLongitude($pickupLongitude)
    {
        $this->pickupLongitude = $pickupLongitude;
        return $this;
    }

    public function setDropoffLocationName($dropoffLocationName)
    {
        $this->dropoffLocationName = $dropoffLocationName;
        return $this;
    }

    public function setDropoffLatitude($dropoffLatitude)
    {
        $this->dropoffLatitude = $dropoffLatitude;
        return $this;
    }

    public function setDropoffLongitude($dropoffLongitude)
    {
        $this->dropoffLongitude = $dropoffLongitude;
        return $this;
    }

    public function setDistance($distance)
    {
        $this->distance = $distance;
        return $this;
    }

    public function setRideType($rideType)
    {
        $this->rideType = $rideType;
        return $this;
    }

    public function setCarTypeId($carTypeId)
    {
        $this->carTypeId = $carTypeId;
        return $this;
    }

    public function setExpectedRideDuration($expectedRideDuration)
    {
        $this->expectedRideDuration = $expectedRideDuration;
        return $this;
    }
}
