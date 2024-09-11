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
            $table->integer('number_of_rooms');
            $table->integer('price_per_night');
            $table->integer('number_of_nights')->nullable();
            $table->integer('original_price')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('total_price');
            $table->date('from_date');
            $table->date('to_date');
            $table->string('payment_method');
            $table->text('description')->nullable();
            $table->json('facilities')->nullable();
            $table->timestamps();

            // Foreign key constraint
           
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
