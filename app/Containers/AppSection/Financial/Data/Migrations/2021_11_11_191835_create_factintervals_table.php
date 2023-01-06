<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFactIntervalsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fact_intervals', function (Blueprint $table) {
            $table->id(); //PK
            $table->string('interval')->unique(); //It should be unique
            $table->timestamps();            
            //$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fact_intervals');
    }
}
