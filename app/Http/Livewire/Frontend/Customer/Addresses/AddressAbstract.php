<?php

namespace App\Http\Livewire\Frontend\Customer\Addresses;

use App\Http\Livewire\Frontend\UserAbstract;
use App\Models\Address;

class AddressAbstract extends UserAbstract
{
    /**
     * The address model for the address we want to show.
     */
    public Address $address;

    /**
     * Set Address as Primary
     *
     * @var bool
     */
    public bool $isPrimary;
}
