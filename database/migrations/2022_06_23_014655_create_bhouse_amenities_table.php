<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBhouseAmenitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bhouse_amenities', function (Blueprint $table) {
            $table->id('bhouse_amenity_id');

            $table->unsignedBigInteger('bhouse_id');
            $table->foreign('bhouse_id')->references('bhouse_id')->on('boarding_houses')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('amenity_id');
            $table->foreign('amenity_id')->references('amenity_id')->on('amenities')
                ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('bhouse_amenities');
    }
}
