<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class Response extends DataTransferObject
{
    public bool $success = false;

    public ?string $message = null;

    public ?DataTransferObject $data = null;
}
