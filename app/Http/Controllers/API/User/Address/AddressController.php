<?php

namespace App\Http\Controllers\API\User\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Address\AddressStoreRequest;
use App\Http\Resources\Users\Address\AddressCollection;
use App\Http\Resources\Users\Address\AddressResource;
use App\Services\AddressManagment;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(protected AddressManagment $addressManagement) // Injection
    {
    }

    public function index(Request $request)
    {
        $addresses = $this->addressManagement->list($request->search);
        $addresses = new AddressCollection($addresses);
        return successResponse($addresses);
    }

    public function store(AddressStoreRequest $request)
    {
        $addressData = $request->validated();
        $addresses = $this->addressManagement->create($addressData);
        $addresses = new AddressResource($addresses);
        return successResponse($addresses, 'تم الحفظ');
    }


    public function destroy($id)
    {
        $this->addressManagement->delete($id);
        return successMessageResponse('تم الحذف');
    }
}
