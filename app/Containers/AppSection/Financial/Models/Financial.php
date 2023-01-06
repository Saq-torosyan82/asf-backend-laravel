<?php

namespace App\Containers\AppSection\Financial\Models;

use App\Ship\Parents\Models\Model;

class Financial extends Model
{
    protected $fillable = [
        'season_id', 
        'club_id',
        'currency',
        'is_blocked',
        'numbers_in'
    ];

    protected $attributes = [

    ];

    protected $hidden = [

    ];

    protected $casts = [
        'is_blocked' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Financial';
}
