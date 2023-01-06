<?php

namespace App\Containers\AppSection\System\Models;

use App\Ship\Parents\Models\Model;

class SportClub extends Model
{
    protected $fillable = [
        'name',
        'league_id',
        'country_id',
        'sport_id',
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
    protected string $resourceKey = 'SportClub';

    public function League()
    {
        return $this->belongsTo(SportLeague::class);
    }

    public function Country()
    {
        return $this->belongsTo(Country::class);
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function factdatas()
    {
        return $this->hasMany(FactData::class);
    }
}
