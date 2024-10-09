<?php

namespace App\Http\Controllers\Dashboard\Dashboard;

use App\Enums\acceptanceStatusEnum;
use App\Enums\RideStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Driver;
use App\Models\Ride;
use App\Models\User;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    private $total_rides = 0;

    public function home()
    {

        if(!user_has_permission('Show.Dashboard')) return redirect(route('dashboard.cards.create'));

        $dashboardData = Cache::remember('dashboard_data', 60 * 60, function () {
            $this->total_rides = Ride::count();
            $data = [
                'ridesCounts' => $this->getRidesCounts(),
                'usersCounts' => $this->getUsersCounts(),
                'driversCounts' => $this->getDriversCounts(),
                'complaintsCounts' => $this->getComplaintsCounts(),
                'zoneStatus' => $this->getZoneStatus(),
                'topUsers' => $this->getTopUsers()->toArray(),
                'topDrivers' => $this->getTopDrivers()->toArray(),
                'topMaleDrivers' => $this->getTopMaleDrivers()->toArray(),
                'topFemaleDrivers' => $this->getTopFemaleDrivers()->toArray(),
            ];

            // Store metadata with expiration time
            $expirationTime = now()->addSeconds(60 * 60);
            Cache::put('dashboard_data_expires_at', $expirationTime, 60 * 60);

            return $data;
        });

        $cacheExpiresAt = Cache::get('dashboard_data_expires_at');

        return view('dashboard.home.home', compact('dashboardData', 'cacheExpiresAt'));
    }
    public function refresh()
    {
        Cache::forget('dashboard_data');
        return redirect()->back()->with('Success', 'تم تحديث بيانات اللوحه');
    }
    public function getRidesCounts()
    {
        return Ride::select(
            DB::raw('COUNT(*) as total_rides'),
            DB::raw('COUNT(CASE WHEN DATE(created_at) = ? THEN 1 END) as today_rides'),
            DB::raw('COUNT(CASE WHEN status = "' . RideStatusEnum::COMPLETED . '" THEN 1 END) as completed_rides')
        )
            ->addBinding(Carbon::today(),  'select')
            ->first();
    }
    public function getUsersCounts()
    {
        return User::select(
            DB::raw('COUNT(*) as total_users'),
            DB::raw('COUNT(CASE WHEN is_verified = ? THEN 1 END) as inactive_users')
        )
            ->addBinding(false, 'select')
            ->first();
    }

    public function getDriversCounts()
    {
        return Driver::select(
            DB::raw('COUNT(*) as total_drivers'),
            DB::raw('COUNT(CASE WHEN acceptance_status = ? THEN 1 END) as accepted_drivers')
        )
            ->addBinding(acceptanceStatusEnum::ACCEPTED, 'select')
            ->first();
    }
    public function getComplaintsCounts()
    {
        return Complaint::select(
            DB::raw('COUNT(*) as total_complaints'),
            DB::raw('COUNT(CASE WHEN is_resolved = ? THEN 1 END) as solved_complaints')
        )
            ->addBinding(true, 'select')
            ->first();
    }
    public function getZoneStatus()
    {
        return Zone::select(
            DB::raw('COUNT(*) as total_zones'),
        )

            ->first();
    }

    public function getTopUsers()
    {
        return User::select('name')
            ->withCount('rides')
            ->withCount([
                'rides as ratio' => function ($query) {
                    $query->select(DB::raw('COUNT(id)*100 / ' . $this->total_rides))
                        ->from('rides');
                }
            ])
            ->orderByDesc('rides_count')
            ->take(10)
            ->get();
    }
    public function getTopDrivers()
    {
        return Driver::select('name')
            ->withCount('rides')
            ->withCount([
                'rides as ratio' => function ($query) {
                    $query->select(DB::raw('COUNT(id)*100 / ' . $this->total_rides))
                        ->from('rides');
                }
            ])
            ->orderByDesc('rides_count')
            ->take(10)
            ->get();
    }
    public function getTopMaleDrivers()
    {
        return Driver::where('gender', 'Male')->select('name')
            ->withCount('rides')
            ->withCount([
                'rides as ratio' => function ($query){
                    $query->select(DB::raw('COUNT(id)*100 / ' . $this->total_rides))
                        ->from('rides');
                }
            ])
            ->orderByDesc('rides_count')
            ->take(10)
            ->get();
    }
    public function getTopFemaleDrivers()
    {
        return Driver::where('gender', 'Female')->select('name')
            ->withCount('rides')
            ->withCount([
                'rides as ratio' => function ($query) {
                    $query->select(DB::raw('COUNT(id)*100 / ' . $this->total_rides))
                        ->from('rides');
                }
            ])
            ->orderByDesc('rides_count')
            ->take(10)
            ->get();
    }
}
