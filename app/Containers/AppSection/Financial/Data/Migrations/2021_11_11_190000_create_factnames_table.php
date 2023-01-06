<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFactNamesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fact_names', function (Blueprint $table) {
            $table->id();
            $table->string('name');            
            $table->unsignedBigInteger('factsection_id')->nullable();
            $table->foreign('factsection_id')->references('id')->on('fact_sections');
            $table->timestamps();
            //$table->softDeletes();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fact_names');
    }
}
