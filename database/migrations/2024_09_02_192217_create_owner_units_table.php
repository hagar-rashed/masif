<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnerUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('unit_type');
            $table->string('unit_area');
            $table->string('location');
            $table->integer('number_of_rooms');
            $table->string('contact_number');
            $table->text('available_entertainment')->nullable();
            $table->integer('number_of_beds');
            $table->decimal('price', 10, 2);
            $table->text('details')->nullable();
            $table->json('payment_methods')->nullable();
            $table->boolean('pets_available')->default(false);
            $table->boolean('add_code_to_telephone')->default(false);
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
        Schema::dropIfExists('owner_units');
    }
}
