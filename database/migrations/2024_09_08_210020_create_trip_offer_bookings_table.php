<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripOfferBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_offer_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Link to user
            $table->foreignId('trip_offer_id')->constrained('offer_trips')->onDelete('cascade'); // Link to trip offer
            $table->integer('passenger_count'); // Number of passengers
            $table->string('qr_code_path')->nullable(); // Path to the QR code
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
        Schema::dropIfExists('trip_offer_bookings');
    }
}
