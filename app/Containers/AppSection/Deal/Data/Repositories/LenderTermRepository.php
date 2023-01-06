<?php

namespace App\Containers\AppSection\Deal\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class LenderTermRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
