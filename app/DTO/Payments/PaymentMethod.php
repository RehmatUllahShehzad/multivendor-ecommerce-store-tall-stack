<?php

namespace App\DTO\Payments;

use Spatie\DataTransferObject\DataTransferObject;

class PaymentMethod extends DataTransferObject
{
    public string $id;

    public string $name;

    public string $cardNumber;

    public string $expMonth;

    public string $expYear;

    public ?string $cvc = null;
}
