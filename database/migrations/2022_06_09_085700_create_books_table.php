<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('book');
            $table->string('title_ar');
            $table->string('title_en');
            $table->longText('desc_ar');
            $table->longText('desc_en');
            $table->string('author_ar');
            $table->string('author_en');
            $table->string('publisher_ar');
            $table->string('publisher_en');
            $table->string('edition_ar');
            $table->string('edition_en');
            $table->text('physical_desc_ar');
            $table->text('physical_desc_en');
            $table->string('image');
            $table->string('file');
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
        Schema::dropIfExists('books');
    }
}
