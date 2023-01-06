<?php

namespace App\Containers\AppSection\Financial\Models;

use App\Ship\Parents\Models\Model;

class FactName extends Model
{
    protected $fillable = [
        'name',
        'factsection_id'
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
    protected string $resourceKey = 'FactName';

    public function factsection()
    {
        return $this->belongsTo(FactSection::class);
    }

    public function factdatas()
    {
        return $this->hasMany(FactValue::class);
    }
}