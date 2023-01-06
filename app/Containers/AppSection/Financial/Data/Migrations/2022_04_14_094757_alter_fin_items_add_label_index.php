<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterFinItemsAddLabelIndex extends Migration
{
    const TBL = 'financial_items';
    const COL = 'label';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn(self::TBL, self::COL)) {
            Schema::table(self::TBL, function (Blueprint $table) {
                $table->index(self::COL);
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
                $table->dropIndex([self::COL]);
            });
        }
    }
}
