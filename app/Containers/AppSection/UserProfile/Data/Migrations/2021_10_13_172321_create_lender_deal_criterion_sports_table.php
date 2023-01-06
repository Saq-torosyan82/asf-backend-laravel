<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLenderDealCriterionSportsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lender_deal_criterion_sports', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('criterion_id');
            $table->foreign('criterion_id')->references('id')->on('lender_deal_criteria')
                ->onDelete('cascade')->onUpdate('cascade');;

            $table->unsignedTinyInteger('sport_id');
            $table->foreign('sport_id')->references('id')->on('sports')
                ->onDelete('cascade')->onUpdate('cascade');;

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lender_deal_criterion_sports');
    }
}
