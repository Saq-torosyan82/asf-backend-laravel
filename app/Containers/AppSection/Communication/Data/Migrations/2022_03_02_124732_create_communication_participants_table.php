<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommunicationParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('communication_participants')) {
            Schema::create('communication_participants', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('communication_id');
                $table->foreign('communication_id')->references('id')->on('communications')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communication_participants');
    }
}
