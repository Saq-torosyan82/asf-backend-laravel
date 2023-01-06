<?php

namespace App\Containers\AppSection\Financial\Data\Repositories;

use App\Containers\AppSection\Financial\Models\FactInterval;
use App\Ship\Parents\Repositories\Repository;

class FactIntervalRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];

    public function model(): string
    {
        return FactInterval::class;
    }
}
