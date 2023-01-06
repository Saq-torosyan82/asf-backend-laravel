<?php

namespace App\Containers\AppSection\UserProfile\Models;

use App\Ship\Parents\Models\Model;

class LenderDealCriteria extends Model
{
    protected $table = 'lender_deal_criteria';

    protected $fillable = [
        'lender_id',
        'type',
        'min_amount',
        'max_amount',
        'min_tenor',
        'max_tenor',
        'min_interest_rate',
        'interest_range',
        'note'
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
    protected string $resourceKey = 'LenderDealCriteria';

    public function countries()
    {
        return $this->hasMany(LenderDealCriterionCountry::class, 'criterion_id');
    }

    public function currencies()
    {
        return $this->hasMany(LenderDealCriterionCurrency::class, 'criterion_id');
    }

    public function sports()
    {
        return $this->hasMany(LenderDealCriterionSport::class, 'criterion_id');
    }
}
