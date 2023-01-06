<?php

namespace App\Containers\AppSection\Financial\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class FinancialRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
