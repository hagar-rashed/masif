<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seat_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seat_id')->constrained('seats')->onDelete('cascade');
            $table->string('seat_numbers'); // Comma-separated values (e.g., A1,A2,B1)
            $table->enum('payment_method', ['cash', 'wallet', 'credit/debit/ATM']);
            $table->integer('number_of_adult_tickets');
            $table->integer('number_of_child_tickets')->nullable()->default(0); // Make optional and default to 0
            $table->decimal('total_price', 8, 2);
            $table->string('qr_code')->nullable();            
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
        Schema::dropIfExists('seat_bookings');
    }
}
