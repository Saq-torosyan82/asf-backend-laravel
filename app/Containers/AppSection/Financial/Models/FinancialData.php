<?php

namespace App\Containers\AppSection\Financial\Models;

use App\Ship\Parents\Models\Model;

class FinancialData extends Model
{
    protected $fillable = [
        'financial_id',
        'item_id',
        'amount'
    ];

    protected $attributes = [

    ];

    protected $hidden = [

    ];

    protected $casts = [
        'amount' => 'float'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'FinancialData';
}
