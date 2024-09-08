<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnerUnitImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner_unit_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_unit_id');
            $table->string('image_path');
            $table->timestamps();

            $table->foreign('owner_unit_id')
                  ->references('id')
                  ->on('owner_units')
                  ->onDelete('cascade');
        });
    }


    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('owner_unit_images');
    }
}
