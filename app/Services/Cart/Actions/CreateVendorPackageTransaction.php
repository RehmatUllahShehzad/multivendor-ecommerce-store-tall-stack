<?php

namespace App\Services\Cart\Actions;

use App\Enums\TransactionStatus;
use App\Models\OrderPackage;
use App\Models\Transaction;
use App\Models\VendorTransaction;

class CreateVendorPackageTransaction
{
    private string $summary = '';

    private ?string $available_at = null;

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
    public function execute(OrderPackage $orderPackage, ?Transaction $transaction = null)
    {
        VendorTransaction::create([
            'summary' => $this->summary,
            'vendor_id' => $orderPackage->vendor_id,
            'transaction_id' => $transaction?->id,
            'amount' => $orderPackage->total() - $orderPackage->service_fee,
            'balance' => $orderPackage->vendor->user->balance ?? 0,
            'status' => TransactionStatus::Pending,
            'available_at' => $this->available_at,
        ]);
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function setAvailableAt(?string $available_at = null): self
    {
        $this->available_at = $available_at;

        return $this;
    }
}
