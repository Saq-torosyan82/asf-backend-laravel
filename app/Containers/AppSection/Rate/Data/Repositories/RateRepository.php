<?php

namespace App\Containers\AppSection\Rate\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class RateRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
