<?php

namespace App\Http\Controllers\API\Zone;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use App\Services\ZoneService;
use Illuminate\Http\Request;

class ZoneController extends Controller
{

    public function AvailableLocation(request $request)
    {
        $zoneService = new ZoneService();
        return successResponse([
            'available' => $zoneService->AvailableLocation([
                $request->latitude, $request->longitude
            ])
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $zone)
    {
        // Toggle the 'active' status
        $zone->update(['active' => !$zone->active]);
        return response()->json(['message' => 'Zone status toggled successfully']);
    }
}
