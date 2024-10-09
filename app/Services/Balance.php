<?php

namespace App\Services;

use App\Enums\RideStatusEnum;
use App\Models\Driver;

/**
 * Class ZoneService
 * @package App\Services
 */
class Balance
{

    private array $balanceDetails = [];
    private Driver $driver;
    private float $total = 0;

    public static function init(): Balance
    {
        return new self();
    }

    public function driverCalculatedBalance(int $driver_id): array
    {
        return $this->loadDriver($driver_id)->calculateDriverCards()->calculateDriverCharges()->calculateDriverRides()
            ->sortBalance()->flatten()->balanceDetails;
    }

    public function loadDriver(int $driver_id): Balance
    {
        $this->driver = Driver::with(['cards', 'charges', 'rides' => function ($q) {
            $q->whereIn('status', [RideStatusEnum::COMPLETED, RideStatusEnum::CANCELLED])->whereNotNull('actual_driver_fare');
        }])->findOrFail($driver_id);
        return $this;
    }

    public function calculateDriverCards(): Balance
    {
        $this->driver->cards->map(function ($q){
            $this->balanceDetails[$q->used_at->format('Y-m-d')][] = [
                'number'        => "#",
                'time'          => $q->used_at->format('Y-m-d h:i a'),
                'value'         => $this->numberFormat($q->amount),
                'type'          => 'income',
                'description'   => 'شحن رصيد من بطاقة شحن',
                'operator'      => '+'
            ];
            $this->total += $q->amount;
        });
        return $this;
    }

    public function calculateDriverCharges(): Balance
    {
        $this->driver->cards->map(function ($q){
            $this->balanceDetails[$q->used_at->format('Y-m-d')][] = [
                'number'        => "#",
                'time'          => $q->used_at->format('Y-m-d h:i a'),
                'value'         => $this->numberFormat($q->amount),
                'type'          => 'income',
                'description'   => 'شحن رصيد من إدارة التطبيق',
                'operator'      => '+'
            ];
            $this->total += $q->amount;
        });
        return $this;
    }

    public function calculateDriverRides(): Balance
    {
        $this->driver->rides->map(function ($q){
            if($q->status == RideStatusEnum::COMPLETED) $this->calculateCompletedRide($q)->calculateAppFare($q);
            else $this->calculateCancelledRide($q);
        });
        return $this;
    }

    public function calculateCompletedRide($q): Balance
    {
        $this->balanceDetails[$q->created_at->format('Y-m-d')][] = [
            'number'        => $q->id,
            'time'          => $q->created_at->format('Y-m-d h:i a'),
            'value'         => $this->numberFormat($q->actual_total_fare),
            'type'          => 'income',
            'description'   => 'رصيد رحلة للسائق',
            'operator'      => '+'
        ];

        if($q->price_before_discount > $q->actual_total_fare){
            $this->balanceDetails[$q->created_at->format('Y-m-d')][] = [
                'number'        => $q->id,
                'time'          => $q->created_at->format('Y-m-d h:i a'),
                'value'         => $this->numberFormat($q->price_before_discount - $q->actual_total_fare),
                'type'          => 'income',
                'description'   => 'رصيد خصم مرحل للسائق',
                'operator'      => '+'
            ];
            $this->total += $q->actual_total_fare + ($q->price_before_discount - $q->actual_total_fare);
        }else $this->total += $q->actual_total_fare;

        return $this;
    }

    public function calculateAppFare($q): Balance
    {
        $this->balanceDetails[$q->created_at->format('Y-m-d')][] = [
            'number'        => $q->id,
            'time'          => $q->created_at->format('Y-m-d h:i a'),
            'value'         => $this->numberFormat($q->actual_app_fare),
            'type'          => 'outcome',
            'description'   => 'عمولة التطبيق من الرحلة',
            'operator'      => '-',
        ];
        $this->total -= $q->actual_app_fare;
        return $this;
    }

    public function calculateCancelledRide($q): Balance
    {
        if($q->driver_cancellation_fees){
            $this->balanceDetails[$q->created_at->format('Y-m-d')][] = [
                'number'        => $q->id,
                'time'          => $q->cancelled_at?->format('Y-m-d h:i a'),
                'value'         => $this->numberFormat($q->driver_cancellation_fees),
                'type'          => 'outcome',
                'description'   => 'غرامة إلغاء رحلة',
                'operator'      => '-'
            ];
        }
        return $this;
    }

    public function sortBalance(): Balance
    {
        krsort($this->balanceDetails);
        return $this;
    }

    public function flatten(): Balance
    {
        $flattenedData = [];
        foreach ($this->balanceDetails as $date => $values) $flattenedData = array_merge($flattenedData, $values);
        $this->balanceDetails = [
            'details' => $flattenedData,
            'total'   => $this->numberFormat($this->total)
        ];
        return $this;
    }

    private function numberFormat($amount): float
    {
        return (float) number_format($amount, 2, '.', '');
    }

}
