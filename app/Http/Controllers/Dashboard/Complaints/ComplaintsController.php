<?php

namespace App\Http\Controllers\Dashboard\Complaints;

use App\Http\Controllers\Controller;
use App\Http\Requests\Complaint\ComplaintStoreRequest;
use App\Http\Resources\Complaints\ComplaintResource;
use App\Models\CarType;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintsController extends Controller
{
    public function create(ComplaintStoreRequest $request)
    {
        $create = Complaint::create($request->validated());
        return $create ? successResponse(new ComplaintResource($create)) : failMessageResponse("Failed to create complaint");
    }

    public function index(Request $request)
    {
        user_can('List.Complaints');
        $records = Complaint::latest()->paginate($request->per_page ?? $request->limit ?? 10);
        return view('dashboard.complaints.index', compact('records'));
    }

    public function show()
    {
        return view('dashboard.complaints.show');
    }

    public function destroy(Complaint $complaint)
    {
        user_can('List.Complaints');
        $complaint->delete();
        return redirect()->back()->with('Success', 'تم الحذف');
    }
}
