<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLenderDealCriterionCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lender_deal_criterion_currencies', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('criterion_id');
            $table->foreign('criterion_id')->references('id')->on('lender_deal_criteria')
                ->onDelete('cascade')->onUpdate('cascade');;

            $table->unsignedSmallInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('lender_criteria')
                ->onDelete('cascade')->onUpdate('cascade');;

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lender_deal_criterion_currencies');
    }
}
