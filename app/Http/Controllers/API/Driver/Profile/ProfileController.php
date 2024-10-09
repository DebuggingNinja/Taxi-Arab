<?php

namespace App\Http\Controllers\API\Driver\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drivers\DeviceTokenRequest;
use App\Http\Requests\Drivers\ProfileImageRequest;
use App\Http\Resources\Drivers\DriverResource;
use App\Http\Resources\Drivers\Profile\ProfileResource;
use App\Http\Resources\Notifications\NotificationCollection;
use App\Http\Resources\Users\Rides\RideHistoryCollection;
use App\Models\Driver;
use App\Models\Notification;
use App\Services\Balance;
use App\Services\FileUploadService;
use App\Services\Firebase;
use Illuminate\Http\Request;
use App\Models\Ride;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $driver = driver_auth()->user();
        if($driver instanceof Driver && $driver?->current_credit_amount <= 0.5 &&
            $driver?->current_credit_amount && $driver?->device_token){
            Firebase::init()->setToken($driver?->device_token)
                ->setTitle('تنبية الرصيد')
                ->setBody('تنبية لقد وصل رصيدك الى' . "({$driver?->current_credit_amount})")->send();
        }else if(!$driver?->current_credit_amount && $driver?->device_token){
            Firebase::init()->setToken($driver?->device_token)
                ->setTitle('تنبية الرصيد')
                ->setBody('يرجى العلم بان رصيدك الحالى قد نفذ')->send();
        }
        return successResponse(new ProfileResource($driver));
    }

    public function balanceDetails(Request $request)
    {
        return successResponse(Balance::init()->driverCalculatedBalance(Auth::id()));
    }

    public function updateProfileImage(ProfileImageRequest $request)
    {

        $images = FileUploadService::upload($request->profile_image, 'drivers', false);

        $driver = driver_auth()->user()->update([
            'personal_image' => $images
        ]);

        if(!$driver) failMessageResponse("فشل تعديل صورة الحساب");

        return successResponse(new DriverResource(driver_auth()->user()),'تم التعديل');
    }

    public function updateDeviceToken(DeviceTokenRequest $request)
    {

        $update = [
            'device_token' => $request->device_token,
            'is_android'   => $request->has('is_android') ? $request->is_android : false
        ];

        $driver = driver_auth()->user()->update($update);

        if(!$driver) failMessageResponse("فشل العملية");

        return successResponse(new DriverResource(driver_auth()->user()),'token updated');
    }

    public function deleteProfile()
    {
        $user = driver_auth()->user();
        if($user?->is_deleted) return failMessageResponse('الحساب غير موجود');
        if($user->update([
            'phone_number' => null,
            'is_deleted' => true,
            'account_phone_number' => $user->phone_number,
        ])){
            $this->revokeToken();
            return successMessageResponse('تم الحذف');
        }
        return failMessageResponse('فشل الحذف');
    }

    public function ridesHistory(Request $request)
    {
        $rides = Ride::with(['car_type', 'discountCard'])->where('driver_id', driver_auth()->id())
            ->latest()->paginate($request->per_page ?? $request->limit ?? 10);
        return successResponse(new RideHistoryCollection($rides));
    }

    public function notificationsHistory(Request $request)
    {
        $user = driver_auth()->user();
        if(!$user?->device_token) return failMessageResponse('لم يتم العثور على التوكن الخاص بالمستخدم');

        $rides = Notification::whereIn('target', ['All Drivers', "All $user?->gender Drivers"])
            ->whereDate('created_at', '>=', $user->created_at)->latest()->paginate($request->per_page ?? $request->limit ?? 10);
        return successResponse(new NotificationCollection($rides));
    }

    public function revokeToken()
    {
        try {
            Auth::user()->tokens->each(fn($token, $key) => $token->delete());
        }catch (\Exception $ex){}
    }
}
