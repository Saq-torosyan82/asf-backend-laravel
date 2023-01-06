<?php

namespace App\Containers\AppSection\System\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class SportNewsRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
