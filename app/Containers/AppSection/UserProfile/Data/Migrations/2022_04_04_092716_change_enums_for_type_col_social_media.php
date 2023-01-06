<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Containers\AppSection\UserProfile\Enums\Key;

class ChangeEnumsForTypeColSocialMedia extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('social_media_followers', function (Blueprint $table) {
            $table->enum('type', [Key::FACEBOOK, Key::TWITTER, Key::YOUTUBE, Key::INSTAGRAM, Key::LINKEDIN])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
}
