<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDealOffersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deal_offers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('deal_id');
            $table->foreign('deal_id')->references('id')->on('deals')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('offer_by');
            $table->foreign('offer_by')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['deal_id', 'offer_by']);

            $table->string('status', 15)->default(\App\Containers\AppSection\Deal\Enums\OfferStatus::NEW)->index();

            $table->unsignedBigInteger('termsheet_id')->nullable();
            $table->foreign('termsheet_id')->references('id')->on('uploads')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->json('termsheet_history')->nullable();

            $table->string('reject_reason', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_offers');
    }
}
