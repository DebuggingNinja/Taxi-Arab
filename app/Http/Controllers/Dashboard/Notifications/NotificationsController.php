<?php

namespace App\Http\Controllers\Dashboard\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\NotificationStoreRequest;
use App\Models\Driver;
use App\Models\Notification;
use App\Models\User;
use App\Models\Zone;
use App\Services\FileUploadService;
use App\Services\Firebase;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{


    public function show()
    {
        return view('dashboard.notifications.create');
    }

    public function store(NotificationStoreRequest $request)
    {
        user_can('List.Notification');

        if($request->user_token){
            $user = User::where('device_token', $request->user_token)->first() ??
                Driver::where('device_token', $request->user_token)->first();
            if(!$user) return redirect()->back()->with('Error', 'المرسل اليه غير محدد');
            $target = [$request->user_token];
            $request->target = $request->user_token;
        }else{
            $target = match ($request->target) {
                'All Drivers' => 'drivers',
                'All Male Drivers' => 'male_drivers',
                'All Female Drivers' => 'female_drivers',
                'All Users' => 'users',
                'All Male Users' => 'male_users',
                'All Female Users' => 'female_users',
                'Not Used' => 'non_active_users',
                default => false,
            };
        }

        $image = null;

        if($request->has('image')) {
            $image = FileUploadService::upload($request->image, 'notifications', 'notifications', false);
            $image = url('uploads/' . $image);
        }

        if(is_array($target)) Firebase::init()
            ->setTitle($request->title)
            ->setBody($request->msg_content)
            ->setImage($image)
            ->sendToMany($target);
        else if($target !== false) Firebase::init()
            ->setTitle($request->title)
            ->setBody($request->msg_content)
            ->setImage($image)
            ->setTopic($target)
            ->sendToMany();
        else return redirect()->back()->with('Error', 'المرسل اليه غير محدد');

        $create = Notification::create([
            'title' => $request->title,
            'content' => $request->msg_content,
            'target' => $request->target,
            'image' => $image
        ]);

        return redirect()->back()->with('Success', 'تم ارسال الاشعار بنجاح');
    }
}
