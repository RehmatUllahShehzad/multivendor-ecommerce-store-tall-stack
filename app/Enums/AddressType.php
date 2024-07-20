<?php

namespace App\Enums;

enum AddressType: string
{
    case Work = 'work';
    case Home = 'home';
    case BILLING = 'billing';
    case SHIPPING = 'shipping';
}
