<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Villages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('villages', function (Blueprint $table) {
            $table->id();
            $table->string('location_ar');
            $table->string('location_en');
            $table->string('lat');
            $table->string('lng');
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('services_ar');
            $table->string('services_en');
            $table->string('owner_name_ar');
            $table->string('owner_name_en');
            $table->string('desc_ar');
            $table->string('desc_en');
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
        //
    }
}
