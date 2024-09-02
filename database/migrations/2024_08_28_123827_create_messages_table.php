<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            
            // Foreign key to chats table
            $table->foreignId('chat_id')->constrained('chats')->onDelete('cascade');
            
            // Foreign key to users table (sender)
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            
            // Foreign key to users table (receiver)
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            
            // Message content
            $table->text('message');
            
            // Read status
            $table->boolean('is_read')->default(false);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index('chat_id');
            $table->index('sender_id');
            $table->index('receiver_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}