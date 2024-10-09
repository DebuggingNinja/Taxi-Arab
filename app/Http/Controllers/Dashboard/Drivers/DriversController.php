<?php

namespace App\Http\Controllers\Dashboard\Drivers;

use App\Enums\acceptanceStatusEnum;
use App\Enums\RideStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Driver\AddDriverBalanceForAgentRequest;
use App\Http\Requests\Dashboard\Driver\AddDriverBalanceRequest;
use App\Http\Requests\Dashboard\Driver\StoreDriverRequest;
use App\Http\Requests\Dashboard\Driver\UpdateDriverRequest;
use App\Models\CarType;
use App\Models\Driver;
use App\Models\DriverChargeLog;
use App\Services\FileUploadService;
use App\Services\Firebase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriversController extends Controller
{
    public function index(request $request)
    {
        user_can('List.Driver');

        $records = Driver::Filters($request)->latest()->paginate($request->per_page ?? $request->limit ?? 10);
        return view('dashboard.drivers.index', compact('records'));
    }

    public function statuses(request $request)
    {
        user_can('List.Driver');
        return view('dashboard.drivers.statuses');
    }

    public function inRide(request $request)
    {
        user_can('List.Driver');
        $records = Driver::with('active_ride')
            ->where('is_blocked', false)
            ->where('is_verified', true)
            ->where('acceptance_status', 'accepted')
            ->whereNotNull('active_ride_id')->get();
        return successResponse($records);
    }

    public function lookingForRide(request $request)
    {
        user_can('List.Driver');
        $records = Driver::with('active_ride')
            ->where('is_blocked', false)
            ->where('is_verified', true)
            ->where('acceptance_status', 'accepted')
            ->where('accepting_rides', true)
            ->whereNull('active_ride_id')->get();
        return successResponse($records);
    }

    public function offline(request $request)
    {
        user_can('List.Driver');
        $records = Driver::with('active_ride')
            ->where('is_blocked', false)
            ->where('is_verified', true)
            ->where('acceptance_status', 'accepted')
            ->where('accepting_rides', false)
            ->whereNull('active_ride_id')
            ->get();
        return successResponse($records);
    }

    public function balanceCharges(request $request)
    {
        user_can('Balance.Review');

        $records = DriverChargeLog::latest()->paginate($request->per_page ?? $request->limit ?? 10);
        return view('dashboard.balance.index', compact('records'));
    }

    public function chargeBalance(request $request)
    {
        user_can('Balance.Charge');

        return view('dashboard.balance.create');
    }

    public function create()
    {
        user_can('Create.Driver');
        $carTypes = CarType::all();
        return view('dashboard.drivers.create', compact('carTypes'));
    }
    public function store(StoreDriverRequest $request)
    {
        user_can('Create.Driver');
        $images = FileUploadService::multiUpload([
            'vehicle_image'                                 => $request->vehicle_image,
            'vehicle_license_image'                         => $request->vehicle_license_image,
            'personal_image'                                => $request->personal_image,
            'personal_license_image'                        => $request->personal_license_image,
            'personal_identification_card_image'            => $request->personal_identification_card_image,
            'personal_criminal_records_certificate_image'   => $request->personal_criminal_records_certificate_image,
        ], 'drivers', false);

        $driver = Driver::create([
            'name'                                          => $request->name,
            'phone_number'                                  => $request->phone_number,
            'gender'                                        => $request->gender,
            'national_id'                                   => $request->national_id,
            'vehicle_registration_plate'                    => $request->vehicle_registration_plate,
            'vehicle_manufacture_date'                      => $request->vehicle_manufacture_date,
            'vehicle_color'                                 => $request->vehicle_color,
            'vehicle_model'                                 => $request->vehicle_model,
            'car_type_id'                                   => $request->car_type_id,
            'vehicle_image'                                 => $images['vehicle_image'],
            'vehicle_license_image'                         => $images['vehicle_license_image'],
            'personal_image'                                => $images['personal_image'],
            'personal_license_image'                        => $images['personal_license_image'],
            'personal_identification_card_image'            => $images['personal_identification_card_image'],
            'personal_criminal_records_certificate_image'   => $images['personal_criminal_records_certificate_image'],

            'accepting_rides'                               => 0,
            'acceptance_status'                             => acceptanceStatusEnum::PENDING,
            'is_verified'                                   => 0,
            'is_blocked'                                    => 0,
            'current_credit_amount'                         => getSetting('DRIVER_INIT_BALANCE')
        ]);
        if($driver && $request->car_types)
            $driver->driver_car_types()->createMany(array_map(fn($i) => ['car_type_id' => $i], $request->car_types));
        return redirect()->route('dashboard.drivers.index')->with('Success', 'تم انشاء السائق بنجاح');
    }
    public function edit(Request $request)
    {
        user_can('Update.Driver');
        $carTypes = CarType::all();
        $record = Driver::findOrFail($request->route('driver'));
        return view('dashboard.drivers.edit', compact('record', 'carTypes'));
    }
    public function update(UpdateDriverRequest $request, Driver $driver)
    {
        user_can('Update.Driver');
        $images = FileUploadService::multiUpload([
            'vehicle_image'                                 => $request->vehicle_image ?? null,
            'vehicle_license_image'                         => $request->vehicle_license_image ?? null,
            'personal_image'                                => $request->personal_image ?? null,
            'personal_license_image'                        => $request->personal_license_image ?? null,
            'personal_identification_card_image'            => $request->personal_identification_card_image ?? null,
            'personal_criminal_records_certificate_image'   => $request->personal_criminal_records_certificate_image ?? null,
        ], 'drivers', false);

        $valid = array_merge($request->validated(), $images);

        $valid['is_asset'] = ($valid['is_asset'] ?? 0) == "on";

        $driver->driver_car_types()->whereNotIn('car_type_id', $request->car_types)->delete();
        $carTypes = array_diff($request->car_types, $driver->driver_car_types->pluck('car_type_id')->toArray());
        $driver->driver_car_types()->createMany(array_map(fn($i) => ['car_type_id' => $i], $carTypes));
        $driver->update($valid);
        return redirect()->back()->with('Success', 'تم تعديل السائق بنجاح');
    }

    public function updateBalance(AddDriverBalanceRequest $request, Driver $driver)
    {
        user_can('Update.Driver');

        $balance = ($driver->current_credit_amount + $request->balance);

        if($request->balance < 0 && ($driver->current_credit_amount + $request->balance) < 0) $balance = 0;

        $driver->update(['current_credit_amount' => $balance]);

        $driver->charges()->create([
            'admin_id'  => Auth::id(),
            'amount'    => $request->balance
        ]);

        if($driver?->device_token)
            Firebase::init()->setToken($driver?->device_token)
                ->setTitle('تم إضافة رصيد لحسابك')
                ->setBody('تم شحن رصيد بقيمة' . $request->balance . 'لحسابك')->send();

        return redirect()->back()->with('Success', 'تم إضافة الرصيد للسائق بنجاح');
    }

    public function updateBalanceForAgents(AddDriverBalanceForAgentRequest $request)
    {
        user_can('Balance.Charge');

        if(!getSetting('ALLOW_PANEL_CHARGE')) return redirect()->back()->with('Error', 'غير مسموح');
        if(($limit = getSetting('MAX_CHARGE_LIMIT')) < $request->balance)
            return redirect()->back()->with('Error', $limit . 'لا يمكن شحن اكثر من ');

        $driver = Driver::where('phone_number', $request->driver_phone)->firstOrFail();

        $balance = ($driver->current_credit_amount + $request->balance);

        if($request->balance <= 0) return redirect()->back()->with('Error', 'الرصيد غير صحيح');

        $driver->update(['current_credit_amount' => $balance]);

        $driver->charges()->create([
            'admin_id'  => Auth::id(),
            'amount'    => $request->balance
        ]);

        if($driver?->device_token)
            Firebase::init()->setToken($driver?->device_token)
                ->setTitle('تم إضافة رصيد لحسابك')
                ->setBody('تم شحن رصيد بقيمة' . $request->balance . 'لحسابك')->send();

        return redirect()->back()->with('Success', 'تم إضافة الرصيد للسائق بنجاح');
    }

    public function show(Driver $driver)
    {
        user_can('Show.Driver');
        $rides = $driver->rides->count();
        $accepted = $driver->rides->whereIn('status', [RideStatusEnum::ACCEPTED, RideStatusEnum::COMPLETED])->count();
        $cancelled = $driver->rides->where('status', RideStatusEnum::CANCELLED)->count();
        return view('dashboard.drivers.show', compact('driver', 'rides', 'accepted', 'cancelled'));
    }

    public function destroy(Driver $driver)
    {
        user_can('Delete.Driver');
        $driver->complaints()->update(['driver_id' => null]);
        $driver->rides()->update(['driver_id' => null]);
        $driver->delete();
        return redirect()->back()->with('Success', 'تم حذف السائق بنجاح');
    }

    public function changeAcceptanceStatus(Request $request, Driver $driver)
    {
        if ($request->method == 'accept') {
            user_can('Accept.Driver');
            $driver->update(['acceptance_status' => 'accepted']);

            return redirect()->back()->with('Success', 'تم قبول السائق بنجاح');
        }
        user_can('Reject.Driver');
        $driver->update(['acceptance_status' => 'rejected']);
        return redirect()->back()->with('Success', 'تم رفض السائق بنجاح');
    }

    public function block(Driver $driver)
    {
        user_can('Block.Driver');
        $driver->update(['is_blocked' => true]);
        return redirect()->back()->with('Success', 'تم حظر السائق بنجاح');
    }

    public function unblock(Driver $driver)
    {
        user_can('Unblock.Driver');
        $driver->update(['is_blocked' => false]);
        return redirect()->back()->with('Success', 'تم فك الحظر عن السائق بنجاح');
    }
}
