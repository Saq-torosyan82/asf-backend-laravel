<?php

namespace App\Containers\AppSection\Communication\Data\Repositories;

use App\Containers\AppSection\Communication\Models\Attachement;
use App\Ship\Parents\Repositories\Repository;

class AttachementRepository extends Repository
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
        return Attachement::class;
    }
}
