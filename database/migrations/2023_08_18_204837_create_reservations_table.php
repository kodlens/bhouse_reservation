<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('reservation_id');
            $table->string('reservation_ref');
            
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('rental_id');
            $table->foreign('rental_id')->references('rental_id')->on('rentals')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('price')->default(0);

            $table->dateTime('book_datetime')->nullable();

            $table->tinyInteger('status')->default(0);
            $table->dateTime('approved_datetime')->nullable();

            $table->string('gcash_receipt_img')->nullable();


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
        Schema::dropIfExists('reservations');
    }
}
