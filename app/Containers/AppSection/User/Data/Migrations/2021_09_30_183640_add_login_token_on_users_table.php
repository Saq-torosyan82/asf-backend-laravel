<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLoginTokenOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->after('remember_token', function ($table) {
                $table->string('login_token', 100)->nullable()->index();
                $table->timestamp('login_token_expire')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('login_token');
            $table->dropColumn('login_token_expire');
        });
    }
}
