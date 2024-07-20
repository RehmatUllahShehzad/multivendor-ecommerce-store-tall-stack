<?php

namespace App\DTO\Payments;

use Spatie\DataTransferObject\DataTransferObject;
use Stripe\AccountLink;

class Account extends DataTransferObject
{
    public ?string $id = null;

    public ?AccountLink $account_links = null;
}
