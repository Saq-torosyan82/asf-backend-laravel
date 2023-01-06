<?php

namespace App\Containers\AppSection\Deal\Models;

use App\Ship\Parents\Models\Model;

class InterestRate extends Model
{
    protected $fillable = [
        'rate_type',
        'entity_type',
        'entity_id',
        'period',
        'amount'
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
    protected string $resourceKey = 'InterestRate';
}
