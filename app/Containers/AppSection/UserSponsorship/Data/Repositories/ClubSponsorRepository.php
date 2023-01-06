<?php

namespace App\Containers\AppSection\UserSponsorship\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class ClubSponsorRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
