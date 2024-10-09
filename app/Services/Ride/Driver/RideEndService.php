<?php

namespace App\Services\Ride\Driver;

use App\Enums\RideStatusEnum;
use App\Events\EndRideEvent;
use App\Models\Ride;
use App\Services\Firebase;
use App\Services\Ride\RideFareCalculator;

class RideEndService
{
    public function calculateActualTime($ride)
    {
        $startedAt = $ride->started_at;
        $now = now();

        // Calculate the difference
        $duration = $startedAt->diff($now);

        // Format the difference as HH:MM:SS
        return sprintf('%02d:%02d:%02d', $duration->h, $duration->i, $duration->s);
    }

    public function endRide($data)
    {
        $ride = Ride::with(['discountCard', 'user', 'driver'])->findOrFail(driver_auth()->user()->active_ride_id);
        // Repricing and give the final price.
        $fareService = new RideFareCalculator($ride->car_type_id);
        $actualFare = $fareService->setRide($ride->id)->calculatePostTripFare($data['actual_distance']);
        // Ending Ride For both Sides
        $ride->user()->endRide();
        $ride->driver()->endRide($actualFare['app_fare']);

        if($ride->user?->device_token){
            $firebase = Firebase::init()->setToken($ride->user?->device_token)
                    ->setTitle('تم إنهاء الرحلة')
                    ->setBody('قام السائق بإنهاء الرحلة');
            if($ride->user?->is_android){
                $firebase->setData([
                    'total_fare' => $actualFare['total_fare']
                ]);
            }
            $firebase->send();
        }

        $total_fare = $actualFare['total_fare'];
        $discount_enabled = false;
        $price_before_discount = null;

        if($ride->discount_card_id){

            $discountCard = $ride->discountCard;

            $total_fare -= (($actualFare['total_fare'] / 100) * $discountCard->percentage_amount);
            $discount_enabled = true;
            $price_before_discount = $actualFare['total_fare'];

        }

        $has_balance_discount = false;
        $discounted_balance_amount = null;

        $DISCOUNT_FROM_BALANCE = getSetting('DISCOUNT_FROM_BALANCE', false);

        if($DISCOUNT_FROM_BALANCE && $ride->user?->current_credit_amount){
            $has_balance_discount = true;
            $discounted_balance_amount = min($DISCOUNT_FROM_BALANCE, $total_fare);

            if($ride->user?->current_credit_amount < $discounted_balance_amount)
                $discounted_balance_amount = $ride->user?->current_credit_amount;
            if(!$price_before_discount) $price_before_discount = $total_fare;
            if(!$discount_enabled) $discount_enabled = true;

            $total_fare -= $discounted_balance_amount;
            $currentBalance = $ride->user?->current_credit_amount - $discounted_balance_amount;

            $ride->user->update([
                'current_credit_amount' => $currentBalance
            ]);
//
//            if($currentBalance <= 0.5 && $currentBalance && $ride->user?->device_token){
//                Firebase::init()->setToken($ride->user?->device_token)
//                    ->setTitle('تنبية الرصيد')
//                    ->setBody('تنبية لقد وصل رصيدك الى' . "($currentBalance)")->send();
//            }else if(!$currentBalance && $ride->user?->device_token){
//                Firebase::init()->setToken($ride->user?->device_token)
//                    ->setTitle('تنبية الرصيد')
//                    ->setBody('يرجى العلم بان رصيدك الحالى قد نفذ')->send();
//            }

            if($ride->driver?->current_credit_amount <= 0.5 && $ride->driver?->current_credit_amount && $ride->driver?->device_token){
                Firebase::init()->setToken($ride->driver?->device_token)
                    ->setTitle('تنبية الرصيد')
                    ->setBody('تنبية لقد وصل رصيدك الى' . "({$ride->driver?->current_credit_amount})")->send();
            }else if(!$ride->driver?->current_credit_amount && $ride->driver?->device_token){
                Firebase::init()->setToken($ride->driver?->device_token)
                    ->setTitle('تنبية الرصيد')
                    ->setBody('يرجى العلم بان رصيدك الحالى قد نفذ')->send();
            }

        }

        $driverUpdatedBalance = $price_before_discount ?
            $ride->driver?->current_credit_amount + (($price_before_discount - $total_fare) - $actualFare['app_fare']) :
            $ride->driver?->current_credit_amount - $actualFare['app_fare'];

        $ride->driver->update(['current_credit_amount' => $driverUpdatedBalance]);

        // Ending Ride Itself
        $ride->update([
            'status'                    => RideStatusEnum::COMPLETED,
            'completed_at'              => now(),
            'actual_distance'           => $data['actual_distance'],
            'actual_ride_duration'      => $this->calculateActualTime($ride),
            'actual_total_fare'         => $total_fare,
            'price_before_discount'     => $price_before_discount,
            'discount_enabled'          => $discount_enabled,
            'actual_driver_fare'        => $actualFare['driver_fare'],
            'actual_app_fare'           => $actualFare['app_fare'],
            'has_balance_discount'      => $has_balance_discount,
            'discounted_balance_amount' => $discounted_balance_amount,
            'dropoff_datetime'          => now()
        ]);

        broadcast(new EndRideEvent($ride->id, $total_fare));

        return [
            'status'                    => true,
            'fare'                      => $actualFare['total_fare'],
            'actual_total_fare'         => $total_fare,
            'price_before_discount'     => $price_before_discount,
            'discount_enabled'          => $discount_enabled,
            'actual_driver_fare'        => $actualFare['driver_fare'],
            'actual_app_fare'           => $actualFare['app_fare'],
            'has_balance_discount'      => $has_balance_discount,
            'discounted_balance_amount' => $discounted_balance_amount,
        ];
    }
}
