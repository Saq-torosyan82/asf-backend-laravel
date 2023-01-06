<?php

namespace App\Containers\AppSection\Upload\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class UploadRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
