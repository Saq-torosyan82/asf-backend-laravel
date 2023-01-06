<?php

namespace App\Containers\AppSection\Deal\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class DealOfferRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        'offer_by' => '=',
        'deal_id' => '=',
    ];
}
