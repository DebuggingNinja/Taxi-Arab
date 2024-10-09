<?php

namespace App\Http\Controllers\API\CarType;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarType\CarTypeStoreRequest;
use App\Http\Requests\CarType\CarTypeUpdateRequest;
use App\Http\Resources\CarType\CarTypeCollection;
use App\Http\Resources\CarType\CarTypeResource;
use App\Models\CarType;
use App\Models\CarTypeSetting;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class CarTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $carTypes = CarType::Enabled()
            ->Search($request->search)
            ->paginate($request->per_page ?? $request->limit ?? 10);

        $carTypes = new CarTypeCollection($carTypes);
        return successResponse($carTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CarTypeStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarTypeStoreRequest $request)
    {
        $data = $request->validated();
        $data['icon'] = FileUploadService::upload($request->icon, 'car_icons', 'TAXI_ARAB_CAR_ICON', false);

        $carType = CarType::create($data);
        CarTypeSetting::insert(
            [
                [
                    'car_type_id'   => $carType->id,
                    'key_name'      => 'BASE_FARE',
                    'value'         => $request->base_fare ?? 0,
                ],
                [
                    'car_type_id'   => $carType->id,
                    'key_name'      => 'KILOMETER_FARE',
                    'value'         => $request->kilometer_fare ?? 0,
                ],
                [
                    'car_type_id'   => $carType->id,
                    'key_name'      => 'LATE_MINUTE_FARE',
                    'value'         => $request->late_minute_fare ?? 0,
                ],
                [
                    'car_type_id'   => $carType->id,
                    'key_name'      => 'MINIMUM_FARE',
                    'value'         => $request->minimum_fare ?? 0,
                ],
            ]
        );
        $carType = new CarTypeResource($carType);
        return successResponse($carType);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarType  $carType
     * @return \Illuminate\Http\Response
     */
    public function show(CarType $carType)
    {
        $carType = new CarTypeResource($carType);
        return successResponse($carType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CarTypeUpdateRequest  $request
     * @param  \App\Models\CarType  $carType
     * @return \Illuminate\Http\Response
     */
    public function update(CarTypeUpdateRequest $request, CarType $carType)
    {
        $data = $request->validated();
        $carType->update($data);

        return successResponse($carType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarType  $carType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarType $carType)
    {
        if ($carType->enabled) {
            $carType->Deactivate();
            return successMessageResponse('تم إلغاء التفعيل');
        }

        $carType->Activate();
        return successMessageResponse('تم التفعيل');
    }
}
