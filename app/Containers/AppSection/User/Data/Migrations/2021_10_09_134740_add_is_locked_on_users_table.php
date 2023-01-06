<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIsLockedOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->after('is_admin', function ($table) {
                $table->boolean('is_locked')->default(false);
            });
            $table->after('password', function ($table) {
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->foreign('parent_id')->references('id')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_locked');
            $table->index('parent_id');
            $table->dropColumn('parent_id');
        });
    }
}
