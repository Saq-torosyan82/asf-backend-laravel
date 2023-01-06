<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommunicationsTable extends Migration
{
    const DEAL_TYPE = 1;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('communications')) {
            Schema::create('communications', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->unsignedBigInteger('deal_id')->nullable();
                $table->integer('type')->default(self::DEAL_TYPE);
                $table->integer('question_type')->nullable();
                $table->timestamps();

                $table->foreign('deal_id')->references('id')->on('deals')
                    ->onDelete('cascade')->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communications');
    }
}
