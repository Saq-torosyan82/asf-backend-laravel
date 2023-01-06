<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFactValuesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fact_values', function (Blueprint $table) {
            $table->id(); //PK
            $table->unsignedBigInteger('fact_name_id'); //FK
            $table->unsignedInteger('club_id'); //FK
            $table->unsignedBigInteger('fact_interval_id')->nullable(); //FK (optional)
            $table->string('value');            
            $table->timestamps();
            $table->foreign('fact_name_id')->references('id')->on('fact_names')->onDelete('cascade');
            $table->foreign('fact_interval_id')->references('id')->on('fact_intervals')->onDelete('cascade');
            $table->foreign('club_id')->references('id')->on('sport_clubs')/*->onDelete('cascade')*/;
            //$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fact_values');
    }
}
