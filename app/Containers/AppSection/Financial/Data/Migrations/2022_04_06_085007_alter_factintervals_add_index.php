<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterFactintervalsAddIndex extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('fact_intervals', 'index')) {
            Schema::table('fact_intervals',
                function (Blueprint $table) {
                    $table->unsignedTinyInteger('index')->after('interval')->nullable()->unique();
                }
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('fact_intervals', 'index')) {
            Schema::table('fact_intervals',
                function (Blueprint $table) {
                    $table->dropColumn('index');
                }
            );
        }
    }
}
