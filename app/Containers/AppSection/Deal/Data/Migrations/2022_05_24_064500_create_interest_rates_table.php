<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInterestRatesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('interest_rates', function (Blueprint $table) {
            $table->id();

            $table->enum('rate_type', [
                \App\Containers\AppSection\Deal\Enums\RateType::NORMAL,
                \App\Containers\AppSection\Deal\Enums\RateType::INSURANCE
            ])->index();

            $table->enum('entity_type', [
                \App\Containers\AppSection\Deal\Enums\RateEntity::CLUB,
                \App\Containers\AppSection\Deal\Enums\RateEntity::BRAND,
                \App\Containers\AppSection\Deal\Enums\RateEntity::MEDIA,
                \App\Containers\AppSection\Deal\Enums\RateEntity::SPONSOR
            ])->index();

            $table->unsignedBigInteger('entity_id')->index();
            $table->unsignedTinyInteger('period');
            $table->double('amount', 4, 2);

            $table->unique(['rate_type', 'entity_type', 'entity_id', 'period']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interest_rates');
    }
}
