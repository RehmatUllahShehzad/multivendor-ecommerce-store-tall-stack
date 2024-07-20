<?php

namespace App\DTO\Payments;

use Spatie\DataTransferObject\DataTransferObject;
use Stripe\Transfer;

class PaymentWithdraw extends DataTransferObject
{
    public ?Transfer $response = null;
}
