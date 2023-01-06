<?php

namespace App\Containers\AppSection\Deal\Models;

use App\Ship\Parents\Models\Model;

class LenderTerm extends Model
{
    protected $fillable = [
        'deal_id', 'user_id'
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
    protected string $resourceKey = 'LenderTerm';

    public function User()
    {
        return $this->belongsTo(\App\Containers\AppSection\User\Models\User::class, 'offer_by', 'id');
    }

    public function Deal()
    {
        return $this->belongsTo(Deal::class, 'id', 'deal_id');
    }
}
