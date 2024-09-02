<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->enum('postulant_type', ['tenant', 'visitor']);
            $table->string('name');
            $table->text('purpose_of_visit');
            $table->integer('number_of_individuals');
            $table->time('visit_time_from');
            $table->time('visit_time_to');
            $table->string('duration_of_visit');
            $table->boolean('pets')->default(false);
            $table->string('pet_type')->nullable();
            $table->boolean('entry_by_vehicle')->default(false);
            $table->string('vehicle_type')->nullable();
            $table->integer('accompanying_individuals')->default(0);
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
        Schema::dropIfExists('visits');
    }
}
