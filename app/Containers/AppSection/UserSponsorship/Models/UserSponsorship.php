<?php

namespace App\Containers\AppSection\UserSponsorship\Models;

use App\Ship\Parents\Models\Model;

class UserSponsorship extends Model
{
    protected $fillable = [
        'user_id', 'type', 'entity_id', 'start_date', 'end_date'
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
    protected string $resourceKey = 'UserSponsorship';
}
