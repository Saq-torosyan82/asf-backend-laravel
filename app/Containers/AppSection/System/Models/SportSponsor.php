<?php

namespace App\Containers\AppSection\System\Models;

use App\Ship\Parents\Models\Model;

class SportSponsor extends Model
{
    protected $fillable = [
        'name',
        'logo'
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
    protected string $resourceKey = 'SportSponsor';
}
