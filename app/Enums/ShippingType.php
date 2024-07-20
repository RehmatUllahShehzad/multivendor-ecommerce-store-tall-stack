<?php

namespace App\Enums;

enum ShippingType: string
{
    case EXPRESS_DELIVERY = 'express';
    case STANDARD_DELIVERY = 'standard';
    case PICKUP = 'pickup';
}
