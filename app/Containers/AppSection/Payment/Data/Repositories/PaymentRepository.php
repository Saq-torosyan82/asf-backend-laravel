<?php

namespace App\Containers\AppSection\Payment\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class PaymentRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
