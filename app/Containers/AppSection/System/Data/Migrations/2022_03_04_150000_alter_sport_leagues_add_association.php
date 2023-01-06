<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterSportLeaguesAddAssociation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sport_leagues', function (Blueprint $table) {
            $table->string('association_name', 50)->after('logo')->nullable();
            $table->string('association_logo', 100)->after('association_name')->nullable();
            $table->unique(['name', 'association_name']);
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
            $table->dropUnique(['name', 'association_name']);
            $table->dropColumn('association_name');
            $table->dropColumn('association_logo');
        });
    }
}
