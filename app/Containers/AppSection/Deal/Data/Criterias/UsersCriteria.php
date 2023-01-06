<?php

namespace App\Containers\AppSection\Deal\Data\Criterias;

use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class UsersCriteria extends Criteria
{
    private array $user_ids;

    public function __construct($user_ids)
    {
        $this->user_ids = $user_ids;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->whereIn('user_id', $this->user_ids);
    }
}
