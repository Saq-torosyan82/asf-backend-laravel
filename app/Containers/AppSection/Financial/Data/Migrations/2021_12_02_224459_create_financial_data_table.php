<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFinancialDataTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('financial_data', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('financial_id');
            $table->foreign('financial_id')->references('id')->on('financials')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedSmallInteger('item_id');
            $table->foreign('item_id')->references('id')->on('financial_items')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->double('amount', 12, 2)->nullable(true); //for empty values

            $table->unique(['financial_id', 'item_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_data');
    }
}
