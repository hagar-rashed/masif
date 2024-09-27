<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();            
            $table->string('name');
            $table->string('image')->nullable(); // Make image nullable
            $table->string('email')->unique();
            $table->enum('user_type', ['company', 'owner', 'visitor']);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('code')->unique()->nullable();
            $table->boolean('isVerified')->default(0);
            $table->string('location')->nullable(); // Add the location field
            $table->decimal('latitude', 10, 8)->nullable(); // Add latitude
            $table->decimal('longitude', 11, 8)->nullable(); // Add longitude
            $table->string('commercial_record')->nullable(); // Add commercial record
            $table->string('tax_card')->nullable(); // Add tax card
            $table->enum('company_activity', ['restaurant', 'cafe', 'cinema','tourism','hotel','market','other'])->nullable(); // Restrict company activity            
            $table->string('social_id')->nullable();
            $table->string('social_type')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
