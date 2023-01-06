<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBorrowerTypes extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'borrower_types',
            function (Blueprint $table) {
                $table->tinyIncrements('id');
                $table->string('name', 50);
                $table->string('type', 20)->index();
                $table->unsignedTinyInteger('index')->unique();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrower_types');
    }
}
