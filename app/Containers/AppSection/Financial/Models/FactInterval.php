<?php

namespace App\Containers\AppSection\Financial\Models;

use App\Ship\Parents\Models\Model;

class FactInterval extends Model
{
    protected $fillable = [
        'interval',
        'index'
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
    protected string $resourceKey = 'FactInterval';

    // public function factdatas()
    // {
    //     return $this->hasMany(FactValue::class);
    // }
}
