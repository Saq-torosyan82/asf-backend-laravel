<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type', 100)->index();
            $table->unsignedBigInteger('entity_id');
            $table->string('entity_type', 255);
            $table->string('subject', 255);
            $table->string('to', 100);
            $table->text('content')->nullable();
            $table->json('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications_logs');
    }
}
