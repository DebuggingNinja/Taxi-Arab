<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\User\AddUserBalanceRequest;
use App\Http\Requests\Dashboard\User\CreateUserRequest;
use App\Http\Requests\Dashboard\User\UpdateUserRequest;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(request $request)
    {
        user_can('List.User');
        $records = User::Filters($request)->latest()->paginate($request->per_page ?? $request->limit ?? 10);
        return view('dashboard.users.index', compact('records'));
    }


    public function create()
    {
        user_can('Create.User');
        return view('dashboard.users.create');
    }
    public function store(CreateUserRequest $request)
    {
        user_can('Create.User');
        $images = FileUploadService::multiUpload([
            'profile_image'                                 => $request->profile_image,
        ], 'users', false);

        User::create([
            'name'                                          => $request->name,
            'phone_number'                                  => $request->phone_number,
            'gender'                                        => $request->gender,
            'profile_image'                                 => $images['profile_image'],
            'is_verified'                                   => 1,
            'is_blocked'                                    => 0,
            'current_credit_amount'                         => getSetting('USER_INIT_BALANCE')
        ]);
        return redirect()->route('dashboard.users.index')->with('Success', 'تم انشاء المستخدم بنجاح');
    }
    public function edit(Request $request)
    {
        user_can('Update.User');
        $record = User::findOrFail($request->route('user'));
        return view('dashboard.users.edit', compact('record'));
    }
    public function update(UpdateUserRequest $request, User $user)
    {
        user_can('Update.User');
        $images = FileUploadService::multiUpload([
            'profile_image'                                 => $request->profile_image ?? null,
        ], 'users', false);

        $valid = array_merge($request->validated(), $images);

        $user->update($valid);
        return redirect()->back()->with('Success', 'تم تعديل المستخدم بنجاح');
    }
    public function show(User $user)
    {
        user_can('Show.User');
        $record = $user;
        return view('dashboard.users.show', compact('record'));
    }


    public function destroy(User $user)
    {
        user_can('Delete.User');
        $user->delete();
        return redirect()->back()->with('Success', 'تم حذف المستخدم بنجاح');
    }

    public function updateBalance(AddUserBalanceRequest $request, User $user)
    {
        user_can('Update.User');
        $user->update([
            'current_credit_amount' => ($user->current_credit_amount + $request->balance)
        ]);
        return redirect()->back()->with('Success', 'تم إضافة الرصيد للمستخدم بنجاح');
    }
    public function block(User $user)
    {
        user_can('Block.User');
        $user->update(['is_blocked' => true]);
        return redirect()->back()->with('Success', 'تم حظر المستخدم بنجاح');
    }

    public function unblock(User $user)
    {
        user_can('Unblock.User');
        $user->update(['is_blocked' => false]);
        return redirect()->back()->with('Success', 'تم فك الحظر عن المستخدم بنجاح');
    }
}
