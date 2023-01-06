<?php

namespace App\Containers\AppSection\Notification\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class NotificationsLogsRepository extends Repository
{
    /**
     * @var array
     */


    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
