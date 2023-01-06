<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFinancialItemsSlagField extends Migration
{
    const TBL = 'financial_items';
    const COL = 'item_slag';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn(self::TBL, self::COL)) {
            Schema::table(self::TBL, function (Blueprint $table) {
                $table->string(self::COL)->after('label')->index();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn(self::TBL, self::COL)) {
            Schema::table(self::TBL, function (Blueprint $table) {
                $table->dropColumn(self::COL);
            });
        }
    }
}
