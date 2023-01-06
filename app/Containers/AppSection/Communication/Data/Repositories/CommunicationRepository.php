<?php

namespace App\Containers\AppSection\Communication\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class CommunicationRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
