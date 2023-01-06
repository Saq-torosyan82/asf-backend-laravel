<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeCommunicationMessageStatusFieldName extends Migration
{
    const OLD_NAME = 'status';
    const NEW_NAME = 'is_read';
    const TABLE = 'communication_messages';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn(self::TABLE, self::OLD_NAME) && !Schema::hasColumn(self::TABLE, self::NEW_NAME)) {
            Schema::table(self::TABLE, function (Blueprint $table) {
                $table->renameColumn(self::OLD_NAME, self::NEW_NAME);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn(self::TABLE, self::NEW_NAME) && !Schema::hasColumn(self::TABLE, self::OLD_NAME)) {
            Schema::table(self::TABLE, function (Blueprint $table) {
                $table->renameColumn(self::NEW_NAME, self::OLD_NAME);
            });
        }
    }
}
