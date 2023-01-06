<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFinancialSectionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('financial_sections', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('label', 30);
            $table->unsignedTinyInteger('index');
            $table->unsignedTinyInteger('nb_years');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_sections');
    }
}
