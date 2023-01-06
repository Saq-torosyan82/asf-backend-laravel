<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterNotificationsLogsAddIndex extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('notifications_logs',
            function (Blueprint $table) {
                $table->index(['type', 'entity_id', 'to']);
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications_logs',
            function (Blueprint $table) {
                $table->dropIndex(['type', 'entity_id', 'to']);
            }
        );
    }
}
