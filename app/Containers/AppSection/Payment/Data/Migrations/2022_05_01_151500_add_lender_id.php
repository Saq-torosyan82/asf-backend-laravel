<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLenderId extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('payments', 'lender_id')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->unsignedBigInteger('lender_id')->after('user_id');
                $table->foreign('lender_id')->references('id')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('payments', 'lender_id')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropForeign(['lender_id']);
                $table->dropColumn('lender_id');
            });
        }
    }
}
