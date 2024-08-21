<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCafesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cafes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->decimal('latitude', 10, 7)->nullable(); 
            $table->decimal('longitude', 10, 7)->nullable(); 
            $table->string('opening_time_from'); 
            $table->string('opening_time_to'); 
            $table->string('image_url')->nullable(); 
            $table->text('description')->nullable(); 
            $table->string('phone', 15)->nullable(); 
            $table->tinyInteger('rating')->unsigned()->default(1); 
            $table->string('delivery_time'); 
            $table->json('busy_rate')->nullable();  
            $table->string('menu_qr_code')->nullable();         
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
        Schema::dropIfExists('cafes');
    }
}
