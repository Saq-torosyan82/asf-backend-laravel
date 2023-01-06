<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFinancialDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'financial_documents',
            function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('financial_id')->nullable();
                $table->foreign('financial_id')->references('id')->on('financials')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->unsignedTinyInteger('section_id');
                $table->foreign('section_id')->references('id')->on('financial_sections')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->unsignedBigInteger('upload_id');
                $table->foreign('upload_id')->references('id')->on('uploads')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_documents');
    }
}
