<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_trips', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('image');            
            $table->text('description');  // Trip description
            $table->float('rating')->default(0);  // Trip rating
            $table->integer('reviews_count')->default(0);  // Number of reviews
            $table->dateTime('start_time');  // Start time of the trip
            $table->dateTime('end_time');  // End time of the trip
            $table->string('destination');  // Destination of the trip
            $table->text('trip_schedule');  // Trip schedule
            $table->string('transportation');  // Transportation info
            $table->string('hotel_name');  // Hotel or accommodation name
            $table->string('hotel_address');  // Hotel address
            $table->decimal('bus_cost', 10, 2);  // Bus cost
            $table->decimal('tax', 10, 2);  // Tax
            $table->decimal('total_cost', 10, 2);  // Total cost
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
        Schema::dropIfExists('offer_trips');
    }
}
