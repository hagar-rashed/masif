<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users
            $table->string('full_name');
            $table->string('mobile_number');
            $table->timestamp('appointment_time');
            $table->enum('number_of_individuals', ['1-3', '4-6', '6-8']);
            $table->enum('payment_method', ['cash_on_restaurant', 'wallet', 'credit/debit/ATM']);
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
        Schema::dropIfExists('restaurant_bookings');
    }
}
