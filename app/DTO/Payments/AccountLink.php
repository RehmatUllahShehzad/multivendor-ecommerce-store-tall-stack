<?php

namespace App\DTO\Payments;

use Spatie\DataTransferObject\DataTransferObject;

class AccountLink extends DataTransferObject
{
    public string $refresh_url;

    public string $return_url;
}
