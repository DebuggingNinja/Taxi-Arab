<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactSupportRequest;
use App\Http\Requests\Dashboard\Login\LoginRequest;
use App\Models\Complaint;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function termsAndConditions()
    {
        return view('home.terms');
    }

    public function supportForm()
    {
        return view('home.support');
    }

    public function supportSubmit(ContactSupportRequest $request)
    {
        return Complaint::create($request->validated()) ?
            redirect()->back()->with('Success', 'Message sent successfully our team will call you soon | تم الارسال سيتم التواصل معك قريبا') :
            redirect()->back()->with('Error', 'Failed to send | فشل الارسال');
    }
}
