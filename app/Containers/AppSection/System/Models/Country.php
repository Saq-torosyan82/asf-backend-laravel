<?php

namespace App\Containers\AppSection\System\Models;

use App\Ship\Parents\Models\Model;

class Country extends Model
{
    protected $fillable = [

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
    protected string $resourceKey = 'Country';

    public function Clubs()
    {
        return $this->hasMany(SportClub::class);
    }
}
