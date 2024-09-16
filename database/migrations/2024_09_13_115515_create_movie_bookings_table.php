<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade'); // Ensure 'movies' is the correct table name
            $table->enum('payment_method', ['cash', 'wallet', 'credit/debit/ATM']);
            $table->dateTime('booking_date_time');       
            $table->integer('adult_tickets');
            $table->integer('child_tickets');
            $table->string('hall');
            $table->string('seats');
            $table->decimal('adult_price', 8, 2); // Add adult_price
            $table->decimal('child_price', 8, 2); // Add child_price
            $table->decimal('total_price', 8, 2);
            $table->string('qr_code')->nullable(); // To
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
        Schema::dropIfExists('movie_bookings');
    }
}
