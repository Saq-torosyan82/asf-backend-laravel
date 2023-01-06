<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColsStartDateEndDate extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_sponsorships', function (Blueprint $table) {
          $table->date('start_date')->nullable()->after('entity_id');
          $table->date('end_date')->nullable()->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(config('user_sponsorships.table_names.roles'), function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');

        });
    }
}
