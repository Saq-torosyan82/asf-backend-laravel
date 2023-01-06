<?php

namespace App\Containers\AppSection\Deal\Models;

use App\Containers\AppSection\Upload\Models\Upload;
use App\Ship\Parents\Models\Model;

class DealOffer extends Model
{
    protected $fillable = [
        'deal_id',
        'offer_by',
        'status',
        'termsheet_id',
        'termsheet_history',
        'reject_reason',
    ];

    protected $attributes = [

    ];

    protected $hidden = [

    ];

    protected $casts = [
        'termsheet_history' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'DealOffer';

    public function user()
    {
        return $this->belongsTo(\App\Containers\AppSection\User\Models\User::class, 'offer_by', 'id');
    }

    public function termsheet()
    {
        return $this->belongsTo(Upload::class, 'termsheet_id', 'id');
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class, 'deal_id', 'id');
    }
}
