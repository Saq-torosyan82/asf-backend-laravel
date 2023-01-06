<?php

namespace App\Containers\AppSection\Payment\Models;

use App\Ship\Parents\Models\Model;

class Payment extends Model
{
    protected $fillable = [
        'is_paid',
        'paid_date',
        'extra_data',
        'date',
        'amount',
        'user_id',
        'deal_id',
        'lender_id',
        'installment_nb'
    ];

    protected $attributes = [

    ];

    protected $hidden = [

    ];

    protected $casts = [
        'extra_data' => 'array',
        'is_paid' => 'boolean'
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at'
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Payment';

    public function User()
    {
        return $this->belongsTo(\App\Containers\AppSection\User\Models\User::class);
    }

    public function Deal()
    {
        return $this->belongsTo(\App\Containers\AppSection\Deal\Models\Deal::class);
    }

    public function Lender()
    {
        return $this->belongsTo(\App\Containers\AppSection\User\Models\User::class);
    }
}
