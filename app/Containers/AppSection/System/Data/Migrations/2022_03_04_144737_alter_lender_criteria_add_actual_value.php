<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterLenderCriteriaAddActualValue extends Migration
{
    const TABLE = 'lender_criteria';
    const COL = 'actual_value';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn(self::TABLE, self::COL)) {
            Schema::table(self::TABLE, function (Blueprint $table) {
                $table->string(self::COL)->after('value')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn(self::TABLE, self::COL)) {
            Schema::table(self::TABLE, function (Blueprint $table) {
                $table->dropColumn(self::COL);
            });
        }
    }
}
