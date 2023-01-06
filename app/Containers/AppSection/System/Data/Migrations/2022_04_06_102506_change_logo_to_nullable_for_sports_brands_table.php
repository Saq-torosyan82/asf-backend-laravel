<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeLogoToNullableForSportsBrandsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('sport_brands', 'logo')) {
            Schema::table('sport_brands', function (Blueprint $table) {
                $table->string('logo', 150)->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sport_brands');
    }
}
