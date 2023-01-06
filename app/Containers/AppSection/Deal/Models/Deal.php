<?php

namespace App\Containers\AppSection\Deal\Models;

use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Containers\AppSection\System\Models\Country;
use App\Containers\AppSection\System\Models\Sport;
use App\Ship\Parents\Models\Model;

class Deal extends Model
{
    protected $fillable = [
        'user_id',
        'deal_type',
        'contract_type',
        'status',
        'reason',
        'currency',
        'contract_amount',
        'upfront_amount',
        'interest_rate',
        'gross_amount',
        'deal_amount',
        'first_installment',
        'frequency',
        'nb_installmetnts',
        'funding_date',
        'created_by',

        'criteria_data',
        'payments_data',
        'fees_data',
        'user_documents',
        'consent_data',
        'contact_data',
        'extra_data',
        'submited_data',
        'contract_data',

        'country_id',
        'sport_id',
        'counterparty'
    ];

    protected $attributes = [

    ];

    protected $hidden = [

    ];

    protected $casts = [
        'criteria_data' => 'array',
        'payments_data' => 'array',
        'fees_data' => 'array',
        'user_documents' => 'array',
        'consent_data' => 'array',
        'contact_data' => 'array',
        'extra_data' => 'array',
        'submited_data' => 'array',
        'contract_data' => 'array'
    ];

    protected $dates = [
        'first_installment',
        'funding_date',
        'created_at',
        'updated_at',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Deal';

    public function user()
    {
        return $this->belongsTo(\App\Containers\AppSection\User\Models\User::class);
    }

    public function offers()
    {
        return $this->hasMany(DealOffer::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function isContractSigned()
    {
        return (($this->status == DealStatus::STARTED) && ($this->reason == StatusReason::CONTRACT_SIGNED));
    }
}
