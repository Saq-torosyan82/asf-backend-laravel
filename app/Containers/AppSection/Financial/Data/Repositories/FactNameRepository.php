<?php

namespace App\Containers\AppSection\Financial\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;
use App\Containers\AppSection\Financial\Models\FactName;

class FactNameRepository extends Repository
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
        return FactName::class;
    }
}
