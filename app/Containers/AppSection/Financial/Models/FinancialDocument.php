<?php

namespace App\Containers\AppSection\Financial\Models;

use App\Ship\Parents\Models\Model;

class FinancialDocument extends Model
{
    protected $fillable = [
        'financial_id',
        'upload_id',
        'section_id',
        'status',
        'reason'
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
    protected string $resourceKey = 'FinancialDocument';
}
