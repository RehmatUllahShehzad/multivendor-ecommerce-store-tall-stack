<?php

namespace App\Console\Commands;

use App\Enums\TransactionStatus;
use App\Models\VendorTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearVendorPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:clear-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will clear pending payments of all vendors';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::transaction(function () {
            $transactions = VendorTransaction::whereDate('available_at', '<', now())->whereNull('cleared_at')->get();

            foreach ($transactions as $transaction) {
                $transaction->update([
                    'cleared_at' => now(),
                ]);

                $user = $transaction->user;

                $user->increment('balance', $transaction->amount);

                VendorTransaction::create([
                    'vendor_id' => $transaction->vendor_id,
                    'summary' => 'Funds cleared',
                    'balance' => $user->balance,
                    'amount' => $transaction->amount,
                    'status' => TransactionStatus::Completed,
                    'cleared_at' => now(),
                ]);
            }
        });

        return Command::SUCCESS;
    }
}
