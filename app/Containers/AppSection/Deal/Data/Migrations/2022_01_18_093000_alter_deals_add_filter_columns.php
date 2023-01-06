<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterDealsAddFilterColumns extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(
            'deals',
            function (Blueprint $table) {
                $table->unsignedSmallInteger('country_id')->after('extra_data')->nullable();
                $table->foreign('country_id')->references('id')->on('countries')
                    ->onDelete('set null')->onUpdate('cascade');

                $table->unsignedTinyInteger('sport_id')->after('country_id')->nullable();
                $table->foreign('sport_id')->references('id')->on('sports')
                    ->onDelete('set null')->onUpdate('cascade');

                $table->string('counterparty', 50)->after('sport_id')->nullable()->index();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'deals',
            function (Blueprint $table) {
                $table->dropForeign(['country_id']);
                $table->dropColumn('country_id');
                $table->dropForeign(['sport_id']);
                $table->dropColumn('sport_id');
                $table->dropColumn('counterparty');
            }
        );
    }
}
