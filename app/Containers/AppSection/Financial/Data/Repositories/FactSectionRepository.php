<?php

namespace App\Containers\AppSection\Financial\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;
use App\Containers\AppSection\Financial\Models\FactSection;

class FactSectionRepository extends Repository
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
        return FactSection::class;
    }
}
