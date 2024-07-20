<?php

namespace App\DTO\Payments;

use Spatie\DataTransferObject\DataTransferObject;

class Withdraw extends DataTransferObject
{
    public float $amount = 0;

    public string $destination = '';
}
