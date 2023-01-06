<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLenderCriteriaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lender_criteria', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('type', 30)->index();
            $table->string('value', 30);
            $table->smallInteger('index')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lender_criteria');
    }
}
