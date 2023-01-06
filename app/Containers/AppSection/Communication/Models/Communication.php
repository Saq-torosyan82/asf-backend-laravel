<?php

namespace App\Containers\AppSection\Communication\Models;

use App\Ship\Parents\Models\Model;

class Communication extends Model
{
    protected $fillable = [
        'title',
        'deal_id',
        'question_type',
        'type'
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
    protected string $resourceKey = 'Communication';

    public function deal()
    {
        return $this->belongsTo(\App\Containers\AppSection\Deal\Models\Deal::class);
    }
}
