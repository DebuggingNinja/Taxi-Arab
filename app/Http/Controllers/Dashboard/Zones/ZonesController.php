<?php

namespace  App\Http\Controllers\Dashboard\Zones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Zone\StoreZoneRequest;
use App\Models\Zone;
use Faker\Core\Coordinates;
use Illuminate\Http\Request;

class ZonesController extends Controller
{
    public function index(Request $request)
    {
        user_can('List.Zone');
        $records = Zone::Filters($request)->latest()->paginate($request->per_page ?? $request->limit ?? 10);
        return view('dashboard.zones.index', compact('records'));
    }
    public function store(StoreZoneRequest $request)
    {
        user_can('Create.Zone');
        $zone = $this->processZone($request->polygon_array);

        if ($zone['error'] ?? false && $zone['error'] == 1) return redirect()->back()->withErrors('في مشكله في النقاط المرسله');
        if ($zone['error'] ?? false && $zone['error'] == 2) return redirect()->back()->withErrors('النقطه لازم تكون مكونه من خط طول وخط عرضي المرسل مش مطابق');
        if ($zone['error'] ?? false && $zone['error'] == 3) return redirect()->back()->withErrors('في مشكله في النقاط المرسله');

        $create = Zone::create([
            'name' => $request->name,
            'active' => 1,
            'polygon' => $zone
        ]);
        return redirect()->route('dashboard.zones.index')->with('Success', 'تم انشاء المنطقه بنجاح');
    }
    public function create()
    {
        user_can('Create.Zone');
        return view('dashboard.zones.create');
    }

    public function destroy(Zone $zone)
    {
        user_can('Delete.Zone');
        $zone->delete();
        return redirect()->back()->with('Success', 'تم حذف المنطقه بنجاح');
    }
    public function processZone($polygon_array)
    {
        $polygonText = $polygon_array;

        // Explode the text into lines
        $lines = explode("\n", $polygonText);

        $polygonArray = [];

        // Check if there are at least 4 lines (1 text line + 3 lat long lines)
        if (count($lines) >= 4) {

            // Iterate through the remaining lines
            for ($i = 1; $i < count($lines); $i++) {
                $line = $lines[$i];
                $coordinates = explode(', ', $line);

                // Make sure there are two coordinates
                if (count($coordinates) == 2) {
                    $latitude = floatval($coordinates[0]);
                    $longitude = floatval($coordinates[1]);

                    // Validate latitude and longitude ranges (adjust as needed)
                    if ($latitude >= -90 && $latitude <= 90 && $longitude >= -180 && $longitude <= 180) {
                        // Add the coordinates to the array
                        $polygonArray[] = [$latitude, $longitude];
                    } else {
                        return ['error' => 1];
                    }
                } else {
                    return ['error' => 2];
                }
            }
        } else {
            return ['error' => 3];
        }

        // Output the resulting array
        return $polygonArray;
    }
}
