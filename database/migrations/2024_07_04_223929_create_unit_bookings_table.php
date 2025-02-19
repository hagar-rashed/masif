<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('price');
            $table->string('status');
            $table->foreignId('unit_id')->references('id')->on('units');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->timestamp("check_out");
            $table->timestamp("check_in")->nullable();
            $table->string('desc');
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
        Schema::dropIfExists('unit_bookings');
    }
}
