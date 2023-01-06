<?php

namespace App\Containers\AppSection\UserProfile\Models;

use App\Ship\Parents\Models\Model;

class LenderDealCriterionCurrency extends Model
{
    protected $fillable = [
        'criterion_id', 'currency_id'
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
    protected string $resourceKey = 'LenderDealCriterionCurrency';
}
