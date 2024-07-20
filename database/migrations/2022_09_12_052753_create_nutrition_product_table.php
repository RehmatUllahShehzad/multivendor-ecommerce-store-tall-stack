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
        Schema::create('nutrition_product', function (Blueprint $table) {
            $table->bigInteger('product_id');
            $table->bigInteger('nutrition_id');
            $table->bigInteger('unit_id');
            $table->string('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nutrition_product', function (Blueprint $table) {
            Schema::dropIfExists('nutrition_product');
        });
    }
};
