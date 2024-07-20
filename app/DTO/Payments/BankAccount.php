<?php

namespace App\DTO\Payments;

use Spatie\DataTransferObject\DataTransferObject;

class BankAccount extends DataTransferObject
{
    public string $account_holder_name = '';

    public string $account_number = '';
}
