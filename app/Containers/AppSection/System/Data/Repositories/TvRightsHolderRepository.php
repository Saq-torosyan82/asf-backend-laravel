<?php

namespace App\Containers\AppSection\System\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class TvRightsHolderRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
