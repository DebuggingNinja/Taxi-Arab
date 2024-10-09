<?php

namespace App\Http\Controllers\Dashboard\CarType;

use App\Enums\acceptanceStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CarType\CarTypeStoreRequest;
use App\Http\Requests\Dashboard\CarType\CarTypeUpdateRequest;
use App\Http\Requests\Dashboard\Driver\StoreDriverRequest;
use App\Http\Requests\Dashboard\Driver\UpdateDriverRequest;
use App\Models\CarType;
use App\Models\CarTypeSetting;
use App\Models\Driver;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class CarTypeController extends Controller
{
    public function index(request $request)
    {
        user_can('List.CarType');
        $records = CarType::Search($request->search)->latest()->paginate($request->per_page ?? $request->limit ?? 10);
        return view('dashboard.carTypes.index', compact('records'));
    }


    public function create()
    {
        user_can('Create.CarType');

        return view('dashboard.carTypes.create');
    }
    public function store(CarTypeStoreRequest $request)
    {
        user_can('Create.CarType');
        $images = FileUploadService::multiUpload([
            'icon'                                 => $request->icon,
        ], 'car_type', false);

        $carType = CarType::create([
            'name'                                          => $request->name,
            'price_factor'                                  => 1,
            'enabled'                                       => 1,
            'icon'                                          => $images['icon'],
            'is_female_type'                                => $request?->is_female_type == "on",
        ]);
        $carType->settings()->insert(
            collect($request->setting)->map(function ($val, $key) use ($carType) {
                return [
                    'car_type_id' => $carType->id,
                    'key_name' => $key,
                    'value' => $val,
                ];
            })->values()->all()
        );
        return redirect()->route('dashboard.car-types.index')->with('Success', 'تم انشاء نوع المركبه بنجاح');
    }
    public function edit(Request $request)
    {
        user_can('Update.CarType');
        $record = CarType::findOrFail($request->route('car_type'));
        return view('dashboard.carTypes.edit', compact('record'));
    }
    public function update(CarTypeUpdateRequest $request, CarType $car_type)
    {
        user_can('Update.CarType');
        $images = FileUploadService::multiUpload([
            'icon' => $request->icon ?? null,
        ], 'car_type', false);

        $car_type->name = $request->name;
        $car_type->is_female_type = $request->is_female_type == "on";
        if ($images['icon'] ?? false)
            $car_type->icon = $images['icon'];
        $car_type->save();
        $settings = collect($request->setting)->map(function ($val, $key) use ($car_type) {
            return [
                'car_type_id' => $car_type->id,
                'key_name'    => $key,
                'value'       => $val,
            ];
        })->values();
        //dd($settings->toArray());
        foreach ($settings->toArray() as $setting)
            $car_type->settings()->updateOrCreate(['car_type_id' => $setting['car_type_id'], 'key_name' => $setting['key_name']], ['value' => $setting['value']]);

        return redirect()->back()->with('Success', 'تم تعديل نوع المركبه بنجاح');
    }
    public function show(CarType $car_type)
    {
        user_can('Show.CarType');
        $record = $car_type;
        return view('dashboard.carTypes.show', compact('record'));
    }


    public function enable(CarType $car_type)
    {
        user_can('Enable.CarType');
        $car_type->update(['enabled' => true]);
        return redirect()->back()->with('Success', 'تم ايقاف نوع المركبه بنجاح');
    }

    public function disable(CarType $car_type)
    {
        user_can('Disable.CarType');
        $car_type->update(['enabled' => false]);
        return redirect()->back()->with('Success', 'تم تشغيل نوع المركبه بنجاح');
    }

    public function destroy(CarType $car_type)
    {
        user_can('Disable.CarType');
        $car_type->delete();
        return redirect()->back()->with('Success', 'تم حذف نوع المركبه بنجاح');
    }
}
