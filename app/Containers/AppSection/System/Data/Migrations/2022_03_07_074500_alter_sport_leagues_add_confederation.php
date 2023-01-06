<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterSportLeaguesAddConfederation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sport_leagues', function (Blueprint $table) {
            $table->string('confederation_name', 50)->after('association_logo')->nullable();
            $table->string('confederation_logo', 100)->after('confederation_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sport_leagues', function (Blueprint $table) {
            $table->dropColumn('confederation_name');
            $table->dropColumn('confederation_logo');
        });
    }
}
