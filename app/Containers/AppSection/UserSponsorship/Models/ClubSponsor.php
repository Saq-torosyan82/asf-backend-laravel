<?php

namespace App\Containers\AppSection\UserSponsorship\Models;

use App\Ship\Parents\Models\Model;

class ClubSponsor extends Model
{
    protected $fillable = [
        'name', 'logo'
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
    protected string $resourceKey = 'ClubSponsor';
}
