<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSportNewsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('sport_news')) {
            Schema::create('sport_news', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('info')->nullable();
                $table->string('image')->nullable();
                $table->string('link');
                $table->dateTime('news_date')->nullable();

                $table->unsignedSmallInteger('country_id')->nullable();
                $table->foreign('country_id')->references('id')->on('countries')
                    ->onDelete('set null')->onUpdate('cascade');

                $table->unsignedTinyInteger('sport_id');
                $table->foreign('sport_id')->references('id')->on('sports')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sport_news');
    }
}
