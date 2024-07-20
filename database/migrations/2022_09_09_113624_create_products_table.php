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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('unit_id');
            $table->string('slug');
            $table->string('title');
            $table->text('description');
            $table->text('attributes');
            $table->text('ingredients');
            $table->integer('available_quantity');
            $table->double('price');
            $table->string('is_published')->default(false)->nullable();
            $table->string('is_featured')->default(false)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
};
