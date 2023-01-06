<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeCommunicationMessageIdFieldName extends Migration
{
    const OLD_NAME = 'communication_message_id';
    const NEW_NAME = 'message_id';
    const TABLE = 'communication_attachements';
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
