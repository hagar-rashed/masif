<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');  // Define 'user_id' column
            $table->string('name');
            $table->string('image_path')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->integer('star_rating')->nullable();
            $table->json('services')->nullable();   // JSON field for services
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels');
    }
}