<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->string('room_type');
            $table->string('space');
            $table->integer('number_of_beds');
            $table->string('service');
            $table->integer('night_price');                       
            $table->text('description')->nullable();
            $table->json('facilities')->nullable();
            $table->string('payment_method');
            $table->integer('discount')->nullable();           
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
        Schema::dropIfExists('rooms');
    }

    

   
}
