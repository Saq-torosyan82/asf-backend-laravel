<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSportClubs extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'sport_clubs',
            function (Blueprint $table) {
                $table->increments('id');

                $table->string('name', 100)->index();

                $table->unsignedSmallInteger('league_id')->nullable();
                $table->foreign('league_id')->references('id')->on('sport_leagues')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->unsignedSmallInteger('country_id')->nullable();
                $table->foreign('country_id')->references('id')->on('countries')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->unsignedTinyInteger('sport_id')->nullable();
                $table->foreign('sport_id')->references('id')->on('sports')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->string('logo', 100)->nullable();

                $table->unique(['country_id', 'name']);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sport_clubs');
    }
}
