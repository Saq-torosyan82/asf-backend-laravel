<?php

namespace App\Containers\AppSection\Financial\Data\Repositories;

use App\Containers\AppSection\Financial\Models\FactValue;
use App\Ship\Parents\Repositories\Repository;

class FactValueRepository extends Repository
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
        return FactValue::class;
    }
}
