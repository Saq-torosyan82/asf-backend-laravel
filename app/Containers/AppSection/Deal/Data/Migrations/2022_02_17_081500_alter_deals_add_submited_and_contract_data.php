<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterDealsAddSubmitedAndContractData extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(
            'deals',
            function (Blueprint $table) {
                $table->json('contract_data')->after('funding_date')->nullable();
                $table->json('submited_data')->after('extra_data')->nullable();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'deals',
            function (Blueprint $table) {
                $table->dropColumn('contract_data');
                $table->dropColumn('submited_data');
            }
        );
    }
}
