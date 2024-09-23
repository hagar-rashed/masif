<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourismsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourisms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->string('name');
            $table->string('image_url');
            $table->string('phone');
            $table->decimal('latitude', 10, 7)->nullable(); 
            $table->decimal('longitude', 10, 7)->nullable(); 
            $table->string('location');
            $table->text('description');  
            $table->json('facilities');
            $table->decimal('rating', 3, 1);
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
        Schema::dropIfExists('tourisms');
    }
}
