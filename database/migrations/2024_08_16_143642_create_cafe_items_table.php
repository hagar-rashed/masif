<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCafeItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
      * @return void
     */
    public function up()
    {
        Schema::create('cafe_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cafe_id')->constrained()->onDelete('cascade');           
            $table->string('name');
            $table->text('description');
            $table->decimal('price_before_discount', 8, 2);
            $table->decimal('price_after_discount', 8, 2);
            $table->enum('calories', ['150 kal', '200 kal', '300 kal']);
            $table->string('image')->nullable();
            $table->decimal('rating');
            $table->decimal('purchase_rate');
            $table->integer('preparation_time');           
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
        Schema::dropIfExists('cafe_items');
    }
}
