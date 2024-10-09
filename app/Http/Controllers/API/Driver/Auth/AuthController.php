<?php

namespace App\Http\Controllers\API\Driver\Auth;

use App\Enums\acceptanceStatusEnum;
use App\Http\Resources\Drivers\DriverResource;
use App\Repository\AuthControllerRepository;
use App\Http\Requests\Drivers\DriverRegisterRequest;
use App\Models\Driver;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class AuthController extends AuthControllerRepository
{
    function __construct()
    {
        $this->authModel = Driver::class;
    }


    public function driverRegisteration(DriverRegisterRequest $request)
    {

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
            'gender'                                        => $request->gender == 'Femal' ? 'Female' : $request->gender,
            'national_id'                                   => $request->national_id,
            'vehicle_registration_plate'                    => $request->vehicle_registration_plate,
            'vehicle_manufacture_date'                      => $request->vehicle_manufacture_date,
            'vehicle_color'                                 => $request->vehicle_color,
            'vehicle_model'                                 => $request->vehicle_model,
            'device_token'                                  => $request->device_token,
            'is_android'                                    => (bool) $request?->is_android ?? false,
            'vehicle_image'                                 => $images['vehicle_image'],
            'vehicle_license_image'                         => $images['vehicle_license_image'],
            'personal_image'                                => $images['personal_image'],
            'personal_license_image'                        => $images['personal_license_image'],
            'personal_identification_card_image'            => $images['personal_identification_card_image'],
            'personal_criminal_records_certificate_image'   => $images['personal_criminal_records_certificate_image'],

            'current_credit_amount'                         => getSetting('DRIVER_INIT_BALANCE', 0),
            'accepting_rides'                               => 0,
            'acceptance_status'                             => acceptanceStatusEnum::PENDING,
            'is_verified'                                   => 0,
            'is_blocked'                                    => 0,
            'otp_attempts',
            'blocked_until',
        ]);

        if(!$driver) failMessageResponse("فشل إنشاء الحساب");

        return successResponse(new DriverResource($driver),'طلبك قيد المراجعه, سنقوم بالتواصل معك خلال الساعات القادمة وسوف يصلك اشعار عند تفعيل حسابك');
    }
}
