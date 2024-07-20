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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_name');
            $table->string('company_name');
            $table->string('company_phone');
            $table->string('company_address');
            $table->text('bio')->nullable();
            $table->boolean('is_active')->default(false);
            $table->integer('deliver_up_to_max_miles')->nullable();
            $table->double('express_delivery_rate')->nullable();
            $table->double('standard_delivery_rate')->nullable();
            $table->boolean('deliver_products')->default(false);
            $table->string('vendor_slug')->nullable();
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
        Schema::dropIfExists('vendors');
    }
};
