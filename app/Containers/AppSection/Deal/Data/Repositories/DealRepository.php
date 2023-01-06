<?php

namespace App\Containers\AppSection\Deal\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class DealRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        'user_id' => '=',
        'contract_type' => '=',
        'status' => '=',
        'deal_type' => '=',
        'country_id' => '=',
        'sport_id' => '=',
        'counterparty' => '=',
        'currency' => '=',
        'created_at' => '=',
    ];
}
