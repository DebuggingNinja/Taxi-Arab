<?php

namespace App\Services;

use App\Models\UserAddress;

class AddressManagment
{
    public $addressesLimit;
    public function __construct()
    {
        $this->addressesLimit = getSetting('MAX_ADDRESSES_LIMIT') ?? 10;
    }

    public function userAddresses()
    {
        return UserAddress::where('user_id', user_auth()->id());
    }
    public function create($address)
    {
        if ($this->userPassedAddressesLimit())
            abort(
                400,
                'The user has reached the maximum limit of addresses (' . $this->addressesLimit . ').'
            );
        return UserAddress::create([
            'user_id'       => user_auth()->id(),
            'label'         => $address['label'],
            'address'       => $address['address'],
            'location_id'   => LocationService::locate($address['latitude'], $address['longitude']),
        ]);
    }

    private function userPassedAddressesLimit()
    {
        return $this->userAddresses()->count() >= $this->addressesLimit;
    }
    public function list($search)
    {
        return $this->userAddresses()->Search($search)->get();
    }

    public function delete($id)
    {
        return $this->userAddresses()->findOrFail($id)->delete();
    }
}
