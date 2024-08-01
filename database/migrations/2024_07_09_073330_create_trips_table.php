<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('from_ar');
            $table->string('from_en');
            $table->string('to_en');
            $table->string('to_ar');
            $table->integer('price');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('duration');
            $table->string('desc_ar');
            $table->string('desc_en');
            $table->integer('passengers');
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
        Schema::dropIfExists('trips');
    }
}