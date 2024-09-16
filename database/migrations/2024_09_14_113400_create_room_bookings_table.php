<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->onDelete('cascade'); // Link to rooms
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('number_of_nights')->nullable();
            $table->integer('original_price')->nullable();
            $table->integer('total_price');
            $table->string('qr_code_path')->nullable();
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
        Schema::dropIfExists('room_bookings');
    }
}
