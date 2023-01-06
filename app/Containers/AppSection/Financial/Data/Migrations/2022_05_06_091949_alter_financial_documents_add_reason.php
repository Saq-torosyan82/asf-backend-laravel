<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterFinancialDocumentsAddReason extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('financial_documents', 'reason')) {
            Schema::table('financial_documents',
                function (Blueprint $table) {
                    $table->string('reason')->after('status')->nullable();
                }
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('financial_documents', 'reason')) {
            Schema::table('financial_documents',
                function (Blueprint $table) {
                    $table->dropColumn('reason');
                }
            );
        }
    }
}
