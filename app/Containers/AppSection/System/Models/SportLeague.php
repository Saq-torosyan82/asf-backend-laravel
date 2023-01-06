<?php

namespace App\Containers\AppSection\System\Models;

use App\Ship\Parents\Models\Model;

class SportLeague extends Model
{
    protected $fillable = [
        'name',
        'sport_id',
        'logo',
        'association_name',
        'association_logo',
        'confederation_name',
        'confederation_logo'
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
    protected string $resourceKey = 'SportLeague';

    public function Sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function SportClubs()
    {
        return $this->hasMany(SportClub::class, 'league_id');
    }
}
