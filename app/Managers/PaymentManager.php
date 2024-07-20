<?php

namespace App\Managers;

use App\Drivers\Payments\StripePayment;
use Illuminate\Support\Manager;

class PaymentManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->config->get('payment.default');
    }

    public function createStripeDriver(): StripePayment
    {
        return new StripePayment();
    }
}
