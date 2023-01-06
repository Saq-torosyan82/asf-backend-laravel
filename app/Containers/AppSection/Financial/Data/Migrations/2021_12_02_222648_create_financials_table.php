<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFinancialsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('financials', function (Blueprint $table) {
            $table->id();

            $table->unsignedTinyInteger('season_id')->nullable();
            $table->foreign('season_id')->references('id')->on('financial_seasons')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('club_id');
            $table->foreign('club_id')->references('id')->on('sport_clubs')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->string('currency', 3)->default(\App\Containers\AppSection\System\Enums\Currency::EUR)->index();

            $table->boolean('is_blocked')->default(false);

            $table->unique(['season_id','club_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financials');
    }
}
