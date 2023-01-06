<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterFinancialDocumentsAddStatus extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('financial_documents', 'status')) {
            Schema::table('financial_documents',
                function (Blueprint $table) {
                    $table->tinyInteger('status')->after('upload_id')->default(0);
                }
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('financial_documents', 'status')) {
            Schema::table('financial_documents',
                function (Blueprint $table) {
                    $table->dropColumn('status');
                }
            );
        }
    }
}
