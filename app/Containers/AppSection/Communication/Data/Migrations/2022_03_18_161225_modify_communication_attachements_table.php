<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ModifyCommunicationAttachementsTable extends Migration
{
    const TABLE = 'communication_attachements';
    const NEW_COL = 'upload_id';
    const OLD_COLS = ['init_file', 'file_name'];
    const REF_TABLE = 'uploads';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (self::OLD_COLS as $col) {
            if (Schema::hasColumn(self::TABLE, $col)) {
                Schema::table(self::TABLE, function (Blueprint $table) use ($col) {
                    $table->dropColumn($col);
                });
            }
        }

        if (!Schema::hasColumn(self::TABLE, self::NEW_COL)) {
            Schema::table(self::TABLE, function (Blueprint $table) {
                $table->unsignedBigInteger(self::NEW_COL)->after('communication_message_id');
                $table->foreign(self::NEW_COL)->references('id')->on(self::REF_TABLE)
                    ->onDelete('cascade')->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn(self::TABLE, self::NEW_COL)) {
            Schema::table(self::TABLE, function (Blueprint $table) {
                $table->dropForeign([self::NEW_COL]);
                $table->dropColumn(self::NEW_COL);
            });
        }

        foreach (self::OLD_COLS as $col) {
            if (!Schema::hasColumn(self::TABLE, $col)) {
                Schema::table(self::TABLE, function (Blueprint $table) use ($col) {
                    $table->string($col);
                });
            }
        }
    }
}
