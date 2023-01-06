<?php

namespace App\Containers\AppSection\UserProfile\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class LenderDealCriterionCountryRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
