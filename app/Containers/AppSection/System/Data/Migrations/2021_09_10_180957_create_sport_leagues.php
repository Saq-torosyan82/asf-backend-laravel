<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSportLeagues extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'sport_leagues',
            function (Blueprint $table) {
                $table->smallIncrements('id');

                $table->unsignedTinyInteger('sport_id');
                $table->foreign('sport_id')->references('id')->on('sports')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->string('name', 50);

                $table->string('logo', 100)->nullable();

                $table->timestamps();
                //$table->softDeletes();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sport_leagues');
    }
}
