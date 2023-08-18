<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardingHouseRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boarding_house_rules', function (Blueprint $table) {
            $table->id('boarding_house_rule_id');

            $table->unsignedBigInteger('bhouse_id');
            $table->foreign('bhouse_id')->references('bhouse_id')->on('boarding_houses')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('rule_id');
            $table->foreign('rule_id')->references('rule_id')->on('rules')
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
        Schema::dropIfExists('boarding_house_rules');
    }
}
