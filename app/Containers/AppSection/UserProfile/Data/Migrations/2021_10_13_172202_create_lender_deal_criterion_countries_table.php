<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLenderDealCriterionCountriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lender_deal_criterion_countries', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('criterion_id');
            $table->foreign('criterion_id')->references('id')->on('lender_deal_criteria')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedSmallInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lender_deal_criterion_countries');
    }
}
