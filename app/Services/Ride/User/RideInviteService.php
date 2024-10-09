<?php

namespace App\Services\Ride\User;

use App\Enums\RideInvitationStatusEnum;
use App\Enums\RideStatusEnum;
use App\Events\RideInviteEvent;
use App\Http\Resources\Drivers\Ride\highlightRideInfoResource;
use App\Http\Resources\Users\Invitations\inviteStatusResource;
use App\Models\Driver;
use App\Models\Ride;
use App\Models\RideInvite;
use App\Services\Firebase;
use Carbon\Carbon;
use Termwind\Components\Dd;

/**
 *
 * Send Invitiation Logic
 * ----------------------
 * 1- Check if there already accepted invitation if so terminate.[Done]
 * 2- Check If there Active Invite with past expiry date and make its status expired [Done]
 * -- check if there Active Invite and not expired () if exists Terminate.
 * 3- Get all driver ids that we already sent before
 * 4- find the closest Driver in range with ignoring any sent invitations
 * 5- send invite if exists, terminate if not exist.
 */
/**
 * Class RideInviteService
 * @package App\Services\Ride\User
 */
class RideInviteService
{
    /**
     * The Ride instance.
     *
     * @var RideInvite|null
     */
    protected $rideInvite;
    /**
     * The Ride instance.
     *
     * @var Ride|null
     */
    protected $ride;
    /**
     * Set the Ride for the service.
     *
     * @param int $rideId
     * @return $this
     */
    public function setRide($rideId = null)
    {
        $this->ride = Ride::with([
            'invitations.driver.location',
            '_pickup_location',
            '_dropoff_location',
            'user.rating',
        ])->find($rideId ?? user_auth()->user()->active_ride_id);
        return $this;
    }

    /**
     * Refresh the Ride information.
     *
     * @return $this
     */
    public function refreshRideInformation()
    {
        return $this->setRide($this->ride->id);
    }

    /**
     * Get invitations based on the specified status.
     *
     * @param string|null $status
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getInvitations($status = null)
    {
        if ($status) return $this->ride?->invitations?->where('status', $status);
        return $this->ride->invitations;
    }
    /**
     * Get the first Pending invitation.
     *
     * @return RideInvite|null
     */
    public function getPendingInvitation()
    {
        return $this->getInvitations(RideInvitationStatusEnum::PENDING)->first();
    }
    /**
     * Get the first accepted invitation.
     *
     * @return RideInvite|null
     */
    public function getAcceptedInvitation()
    {
        return $this->getInvitations(RideInvitationStatusEnum::ACCEPTED)->first();
    }
    /**
     * Check if there are accepted invitations.
     *
     * @return bool
     */
    public function isTherePendingInvites()
    {
        if ($this->rideInvite = $this->getPendingInvitation()) return true;
        return false;
    }

    /**
     * Check if there are accepted invitations.
     *
     * @return bool
     */
    public function isThereAcceptedInvites()
    {
        if ($this->rideInvite = $this->getAcceptedInvitation()) return true;
        return false;
    }

    /**
     * Get active invitations with past expiry date.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveInvitesPastExpiryDate()
    {
        return $this->getInvitations(RideInvitationStatusEnum::PENDING)
            ->where('expired_at', '<', Carbon::now());
    }

    /**
     * Expire active invitations with past expiry date.
     *
     * @return void
     */
    public function expireActiveInvitesPastExpiryDate()
    {
        if ($expiredInvitations = $this->getActiveInvitesPastExpiryDate())
            $t = RideInvite::whereIn('id', $expiredInvitations->pluck('id'))->expire();
    }

    /**
     * Get the driver IDs that have been invited.
     *
     * @return \Illuminate\Support\Collection
     */
    public function invitedDriverIds()
    {
        return $this->getInvitations()->pluck('driver_id');
    }

    /**
     * Get the driver IDs that have been invited.
     *
     * @return \Illuminate\Support\Collection
     */
    public function pendingDrivers()
    {
        return RideInvite::where('status', RideInvitationStatusEnum::PENDING)
            ->whereDate('expired_at', '>=', now())
            ->whereDoesntHave('ride', fn($q) => $q->where('status', RideStatusEnum::CANCELLED))
            ->pluck('driver_id');
    }

    /**
     * Get the closest driver to the Ride location.
     *
     * @return Driver|null
     */
    public function getClosestDriverToRide()
    {
        $driver = Driver::selectRaw('*,drivers.id as id,
            (6371 * acos(cos(radians(?))
            * cos(radians(locations.latitude))
            * cos(radians(locations.longitude) - radians(?))
            + sin(radians(?))
            * sin(radians(locations.latitude)))) AS distance', [
            $this->ride->_pickup_location->latitude,
            $this->ride->_pickup_location->longitude,
            $this->ride->_pickup_location->latitude,
        ])
            ->join('locations', 'drivers.latest_location_id', '=', 'locations.id')
            ->join('driver_car_types', 'drivers.id', '=', 'driver_car_types.driver_id')
            ->whereNotIn('drivers.id', array_merge(
                    array_values($this->invitedDriverIds()->toArray()),
                    array_values($this->pendingDrivers()->toArray()),
                )
            )
            ->whereHas('driver_car_types', fn ($query) => $query->where('car_type_id', $this->ride->car_type_id))
            ->where('drivers.accepting_rides', true);

        $driver->having('distance', '<=', getSetting('DRIVER_SEARCH_RADIUS') ?? 5);

        if(getSetting('ACTIVATE_ASSET_DRIVER') ?? false) $driver->orderBy('drivers.is_asset', 'desc');

        return $driver->orderBy('distance')
            ->AvailableForRide()
            ->first();
    }

    /**
     *
     * Send Invitation Logic
     * ----------------------
     * 1- Check if there already accepted invitation if so terminate.[Done]
     * 2- Check If there Active Invite with past expiry date and make its status expired [Done]
     * -- check if there Active Invite and not expired () if exists Terminate.
     * 3- Get all driver ids that we already sent before
     * 4- find the closest Driver in range with ignoring any sent invitations
     * 5- send invite if exists, terminate if not exist.
     */


    /**
     * Send a ride invitation.
     *
     * @return void
     */
    public function sendInvite()
    {
        // 1- Check if there is an active invite with a past expiry date and make its status expired.
        $this->expireActiveInvitesPastExpiryDate();
        $this->refreshRideInformation();

        // 2- Check if there already accepted invitation, if so terminate.
        if ($this->isThereAcceptedInvites())
            return $this->rideInvite;

        // 3- Check if there already Pending invitation, if so terminate.
        if ($this->isTherePendingInvites())
            return $this->rideInvite;

        // 4- Find the closest Driver in range with ignoring any sent invitations.
        $closestDriver = $this->getClosestDriverToRide();

        $expiry = getSetting('INVITE_EXPIRY_TIMEOUT') ?? 60;

        // 5- Send invite if the closest driver exists and has not been invited before, terminate if not exist.
        if ($closestDriver) {
            $invite = RideInvite::create([
                'ride_id'       => $this->ride->id,
                'driver_id'     => $closestDriver->id,
                'expired_at'    => Carbon::now()->addSeconds($expiry),
                'status'        => RideInvitationStatusEnum::PENDING
            ]);
            $invite =  $invite->load('driver.location');

            if($closestDriver?->device_token)
                Firebase::init()->setToken($closestDriver?->device_token)
                    ->setTitle('لديك دعوة جديدة')
                    ->setBody('لديك دعوة لرحلة')
                    ->setData([
                        'invite_information' => new inviteStatusResource($invite),
                        'ride_information'  => new highlightRideInfoResource($this->ride)
                    ])->send($expiry, 'ride_invitation.mp3');

            // Send Event To DRIVER & User that his invite been sent and expires at:
            broadcast(new RideInviteEvent($this->ride, $closestDriver, $invite));
            return $invite;
        }
        return null;
    }
}
