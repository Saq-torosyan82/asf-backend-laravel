<?php

namespace App\Containers\AppSection\Communication\Data\Repositories;

use App\Containers\AppSection\Communication\Models\Participant;
use App\Ship\Parents\Repositories\Repository;

class ParticipantRepository extends Repository
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
        return Participant::class;
    }
}
