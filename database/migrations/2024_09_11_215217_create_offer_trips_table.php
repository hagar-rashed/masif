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
            $table->unsignedBigInteger('user_id'); // Add this line
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Add this line
            $table->unsignedBigInteger('tourism_id'); // Add this line
            $table->foreign('tourism_id')->references('id')->on('tourisms')->onDelete('cascade'); // Add this line
            $table->string('name'); 
            $table->string('image_path')->nullable();  // Make this nullable            
            $table->text('description');  
            $table->float('rating')->default(0);  
            $table->integer('reviews_count')->default(0);  // Number of reviews
            $table->dateTime('start_time');  // Start time of the trip
            $table->dateTime('end_time');  // End time of the trip
            $table->string('destination');  // Destination of the trip
            $table->text('trip_schedule');  // Trip schedule
            $table->string('transportation');  // Transportation info
            $table->string('hotel_name');  // Hotel or accommodation name
            $table->string('hotel_address');  
            $table->string('hotel_phone')->nullable();
            $table->decimal('cost_before_discount', 10, 2)->nullable();  
            $table->decimal('trip_cost', 10, 2);  
            $table->decimal('tax', 10, 2);  
            $table->decimal('total_cost', 10, 2);  
            
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
