<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrcodesTable extends Migration
{
    public function up()
    {
        Schema::create('qrcodes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('village_name');
            $table->date('starting_date');
            $table->date('expiration_date');
            $table->integer('duration');
            $table->string('code_type');
            $table->string('code')->unique();
            $table->string('qr_code')->nullable();           
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('qrcodes');
    }
}
