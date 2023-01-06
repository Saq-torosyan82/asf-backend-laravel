<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommunicationMessagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('communication_messages')) {
            Schema::create('communication_messages', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('sender');
                $table->foreign('sender')->references('id')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->text('message_body')->nullable();

                $table->unsignedBigInteger('communication_id');
                $table->foreign('communication_id')->references('id')->on('communications')
                    ->onDelete('cascade')->onUpdate('cascade');
                $table->boolean('is_read')->default(0);

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communication_messages');
    }
}
