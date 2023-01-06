<?php

namespace App\Containers\AppSection\UserSponsorship\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class UserSponsorshipRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
