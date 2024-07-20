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
        Schema::create('order_packages_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_package_id');
            $table->foreignId('product_id');

            $table->double('price')->default(0);
            $table->integer('quantity')->unsigned();
            $table->json('meta')->nullable();

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
        Schema::dropIfExists('order_packages_items');
    }
};
