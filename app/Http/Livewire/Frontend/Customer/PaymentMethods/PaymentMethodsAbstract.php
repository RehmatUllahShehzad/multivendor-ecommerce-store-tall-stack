<?php

namespace App\Http\Livewire\Frontend\Customer\PaymentMethods;

use App\Http\Livewire\Frontend\UserAbstract;

class PaymentMethodsAbstract extends UserAbstract
{
    /**
     * Set Payment as Primary
     *
     * @var bool
     */
    public bool $isPrimary;
}
