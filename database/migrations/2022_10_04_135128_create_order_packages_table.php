<?php

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
        Schema::create('order_packages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vendor_id');
            $table->foreignId('order_id');

            $table->double('service_fee');
            $table->double('sub_total');
            $table->double('shipping_fee')->default(0);
            $table->string('tracking_number')->nullable();
            $table->string('type');
            $table->json('meta')->nullable();
            $table->string('status')->default('processing');

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
        Schema::dropIfExists('order_packages');
    }
};
