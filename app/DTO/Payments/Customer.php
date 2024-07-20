<?php

namespace App\DTO\Payments;

use Spatie\DataTransferObject\DataTransferObject;

class Customer extends DataTransferObject
{
    public string $id;

    public string $name;

    public string $email;
}
