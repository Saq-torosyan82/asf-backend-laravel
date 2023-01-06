<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFinancialItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('financial_items', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('label', 200);

            $table->unsignedTinyInteger('section_id');
            $table->foreign('section_id')->references('id')->on('financial_sections')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedTinyInteger('group_id')->index();
            $table->unsignedTinyInteger('index')->index();
            $table->string('style', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_items');
    }
}
