<?php

namespace App\Enums;

enum VendorStatus: string
{
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Pending = 'pending';
}
