<?php

namespace App\DTO\Payments;

use Spatie\DataTransferObject\DataTransferObject;

class CardAccount extends DataTransferObject
{
    public string $name_on_card = '';

    public string $card_number = '';

    public string $month = '';

    public string $year = '';

    public string $cvc = '';

    public string $first_address = '';

    public string $second_address = '';
}
