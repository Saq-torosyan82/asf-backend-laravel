<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommunicationAttachementsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('communication_attachements')) {
            Schema::create('communication_attachements', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('communication_message_id');
                $table->foreign('communication_message_id')->references('id')->on('communication_messages')
                    ->onDelete('cascade')->onUpdate('cascade');
                $table->string('init_file');
                $table->string('file_name');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communication_attachements');
    }
}
