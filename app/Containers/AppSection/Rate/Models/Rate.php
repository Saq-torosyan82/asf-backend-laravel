<?php

namespace App\Containers\AppSection\Rate\Models;

use App\Ship\Parents\Models\Model;

class Rate extends Model
{
    protected $fillable = [
        'currency', 'value'
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
    protected string $resourceKey = 'Rate';
}
