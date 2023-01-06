<?php

namespace App\Containers\AppSection\UserProfile\Models;

use App\Ship\Parents\Models\Model;

class SocialMediaFollowers extends Model
{
    protected $table = 'social_media_followers';
    protected $fillable = [
        'user_id',
        'type',
        'link',
        'nb_followers',
        'last_checked',
    ];

    protected $attributes = [

    ];

    protected $hidden = [

    ];

    protected $casts = [

    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'SocialMediaFollowers';
}
