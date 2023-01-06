<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSocialMediaFollowersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_media_followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->string('type', 30)->index();
            $table->string('link', 150)->unique()->index();
            $table->unsignedInteger("nb_followers")->default(0);
            $table->date("last_checked")->nullable();
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media_followers');
    }
}
