<?php

use App\Enums\TransactionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_transactions', function (Blueprint $table) {
            $table->id();
            $table->text('summary')->nullable();
            $table->foreignId('transaction_id')->nullable();
            $table->foreignId('vendor_id')->nullable();

            $table->double('amount')->nullable();
            $table->double('balance');

            $table->string('status')->default('pending')->comment(collect(TransactionStatus::cases())->map(fn ($status) => $status->value)->implode(','));

            $table->timestamp('cleared_at')->nullable();
            $table->timestamp('available_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_transactions');
    }
};
