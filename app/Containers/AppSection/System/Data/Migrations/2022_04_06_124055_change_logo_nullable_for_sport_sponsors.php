<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeLogoNullableForSportSponsors extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('sport_sponsors', 'logo')) {
            Schema::table('sport_sponsors', function (Blueprint $table) {
                $table->string('logo', 150)->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sport_sponsors');
    }
}
