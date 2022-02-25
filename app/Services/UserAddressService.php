<?php

namespace App\Services;

use App\Enums\State;
use App\Models\UserAddress;

class UserAddressService
{
    public UserAddress $userAddress;

    /**
     * Set a user.
     *
     * @param UserAddress $userAddress
     * @return $this
     */
    public function setAddress(UserAddress $userAddress): self
    {
        $this->userAddress = $userAddress;

        return $this;
    }

    /**
     * Get current user.
     *
     * @return UserAddress
     */
    public function getAddress(): UserAddress
    {
        return $this->userAddress;
    }

    public function create(
        int $userId,
        string $zipcode,
        string $address,
        int $number,
        string $district,
        string $city,
        State $state,
        ?string $complement
    ): self {
        $this->userAddress = new UserAddress();
        $this->userAddress->user_id = $userId;
        $this->userAddress->zipcode = $zipcode;
        $this->userAddress->address = $address;
        $this->userAddress->number = $number;
        $this->userAddress->district = $district;
        $this->userAddress->city = $city;
        $this->userAddress->state = $state;
        $this->userAddress->complement = $complement ?? null;
        $this->userAddress->save();

        return $this;
    }

    public function update(array $userAddressData): self {
        $this->userAddress->update($userAddressData);

        return $this;
    }
}
