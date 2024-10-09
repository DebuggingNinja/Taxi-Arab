<?php

namespace App\Http\Controllers\API\User\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drivers\DeviceTokenRequest;
use App\Http\Requests\Drivers\ProfileImageRequest;
use App\Http\Resources\Notifications\NotificationCollection;
use App\Http\Resources\Users\Profile\ProfileResource;
use App\Http\Resources\Users\Rides\RideHistoryCollection;
use App\Models\Notification;
use App\Models\Ride;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = new ProfileResource(Auth::guard('user')->user());
        return successResponse($user);
    }

    public function updateProfileImage(ProfileImageRequest $request)
    {

        $images = FileUploadService::upload($request->profile_image, 'drivers', false);

        $driver = user_auth()->user()->update([
            'profile_image' => $images
        ]);

        if(!$driver) failMessageResponse("فشل تعديل صورة الحساب");

        return successResponse(new ProfileResource(user_auth()->user()),'تم التعديل');
    }

    public function updateDeviceToken(DeviceTokenRequest $request)
    {

        $update = [
            'device_token' => $request->device_token,
            'is_android'   => $request->has('is_android') ? $request->is_android : false
        ];

        $driver = user_auth()->user()->update($update);

        if(!$driver) failMessageResponse("فشل التعديل");

        return successResponse(new ProfileResource(user_auth()->user()),'token updated');
    }

    public function deleteProfile()
    {
        $user = user_auth()->user();
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
        $rides = Ride::with(['car_type', 'discountCard'])->where('user_id', user_auth()->id())
            ->latest()->paginate($request->per_page ?? $request->limit ?? 10);
        return successResponse(new RideHistoryCollection($rides));
    }

    public function notificationsHistory(Request $request)
    {
        $user = user_auth()->user();

        if(!$user?->device_token) return failMessageResponse('please update yor fcm token');

        $type = ['All Users', "All $user?->gender Users"];

        if(!$user->rides?->count()) $type[] = 'Not Used';

        $rides = Notification::whereIn('target', $type)->whereDate('created_at', '>=', $user->created_at)
            ->latest()->paginate($request->per_page ?? $request->limit ?? 10);
        return successResponse(new NotificationCollection($rides));
    }

    public function revokeToken()
    {
        try {
            Auth::user()->tokens->each(fn($token, $key) => $token->delete());
        }catch (\Exception $ex){}
    }

}
