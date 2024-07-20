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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id');
            $table->foreignId('product_id');
            $table->foreignId('order_id');

            $table->integer('rating')->default(5);
            $table->text('comment')->nullable();

            $table->string('status', 10)->default('pending');
            $table->text('vendor_reply')->nullable();

            $table->boolean('is_new')->default(0);

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
        Schema::dropIfExists('reviews');
    }
};
