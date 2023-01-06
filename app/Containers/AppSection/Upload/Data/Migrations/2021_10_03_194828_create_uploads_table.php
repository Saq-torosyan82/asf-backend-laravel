<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('privacy', 20)->index();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('uploaded_by');
            $table->foreign('uploaded_by')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->string('init_file_name', 100);
            $table->string('file_mime', 150);
            $table->unsignedBigInteger('file_size');
            $table->string('file_name', 100);
            $table->string('file_path', 200);
            $table->json('extra_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploads');
    }
}
