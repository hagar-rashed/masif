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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('postulant_type');
            $table->string('name');
            $table->string('purpose_of_visit');
            $table->integer('number_of_individuals');
            $table->dateTime('visit_time_from');
            $table->dateTime('visit_time_to');
            $table->string('duration_of_visit'); // Duration in minutes
            $table->boolean('pets')->default(false);
            $table->string('pet_type')->nullable();
            $table->boolean('entry_by_vehicle')->default(false);
            $table->string('vehicle_type')->nullable();
            $table->integer('accompanying_individuals')->default(0);
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
        Schema::dropIfExists('visits');
    }
}
