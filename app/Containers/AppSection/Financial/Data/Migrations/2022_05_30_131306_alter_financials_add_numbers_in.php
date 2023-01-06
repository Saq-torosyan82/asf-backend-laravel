<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterFinancialsAddNumbersIn extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('financials', 'numbers_in')) {
            Schema::table('financials',
                function (Blueprint $table) {
                    $table->string('numbers_in')->after('currency')->nullable();
                }
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('financials', 'numbers_in')) {
            Schema::table('financials',
                function (Blueprint $table) {
                    $table->dropColumn('numbers_in');
                }
            );
        }
    }
}
