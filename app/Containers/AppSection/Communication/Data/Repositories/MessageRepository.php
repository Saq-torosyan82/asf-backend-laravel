<?php

namespace App\Containers\AppSection\Communication\Data\Repositories;

use App\Containers\AppSection\Communication\Models\Message;
use App\Ship\Parents\Repositories\Repository;

class MessageRepository extends Repository
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
        return Message::class;
    }
}
