<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id('rental_id');
            $table->unsignedBigInteger('bhouse_id');
            $table->foreign('bhouse_id')->references('bhouse_id')->on('boarding_houses')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('rental_name')->nullable();
            $table->string('rental_desc')->nullable();
            $table->string('rental_type')->nullable();
            $table->string('amenities')->nullable();
            $table->double('price')->default(0);
            $table->string('rental_img_path')->nullable();

            $table->tinyInteger('is_reserved')->default(0);
            $table->tinyInteger('is_occupied')->default(0);

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
        Schema::dropIfExists('rentals');
    }
}
