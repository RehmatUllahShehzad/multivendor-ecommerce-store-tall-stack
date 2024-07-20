<?php

namespace App\Enums;

enum ReviewStatus: string
{
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case PENDING = 'pending';
}
