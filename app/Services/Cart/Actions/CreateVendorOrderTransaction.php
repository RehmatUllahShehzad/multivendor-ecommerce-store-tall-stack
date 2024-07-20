<?php

namespace App\Services\Cart\Actions;

use App\Models\Order;
use App\Models\Transaction;

class CreateVendorOrderTransaction
{
    public function __construct()
    {
        //
    }

    /**
     * Execute the action.
     *
     *
     * @return void
     */
    public function execute(Order $order, Transaction $transaction)
    {
        foreach ($order->packages as $orderPackage) {
            app(CreateVendorPackageTransaction::class)
            ->setSummary(sprintf('Order Revenue <a href="%s" target="blank" >(View Order)</a>', route('vendor.orders.show', $orderPackage->id)))
            ->setAvailableAt(null)
            ->execute($orderPackage, $transaction);
        }
    }
}
