<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalImgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_imgs', function (Blueprint $table) {
            $table->id('rental_img_id');
            $table->unsignedBigInteger('rental_id');
            $table->foreign('rental_id')->references('rental_id')->on('rentals')->onDelete('cascade');
            $table->string('rental_img_path')->nullable();
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
        Schema::dropIfExists('rental_imgs');
    }
}
