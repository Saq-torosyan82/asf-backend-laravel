<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLenderDealCriteriaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lender_deal_criteria', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lender_id');
            $table->foreign('lender_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedSmallInteger('type');
            $table->foreign('type')->references('id')->on('lender_criteria')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedSmallInteger('min_amount');
            $table->foreign('min_amount')->references('id')->on('lender_criteria')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedSmallInteger('max_amount');
            $table->foreign('max_amount')->references('id')->on('lender_criteria')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedSmallInteger('min_tenor');
            $table->foreign('min_tenor')->references('id')->on('lender_criteria')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedSmallInteger('max_tenor');
            $table->foreign('max_tenor')->references('id')->on('lender_criteria')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedSmallInteger('min_interest_rate');
            $table->foreign('min_interest_rate')->references('id')->on('lender_criteria')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedSmallInteger('interest_range');
            $table->foreign('interest_range')->references('id')->on('lender_criteria')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->string('note', 250)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lender_deal_criteria');
    }
}
