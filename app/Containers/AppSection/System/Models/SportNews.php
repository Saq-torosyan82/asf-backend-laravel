<?php

namespace App\Containers\AppSection\System\Models;

use App\Ship\Parents\Models\Model;

class SportNews extends Model
{
    protected $fillable = [
        'title',
        'info',
        'image',
        'link',
        'news_date',
        'country_id',
        'sport_id'
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
    protected string $resourceKey = 'SportNews';
}
