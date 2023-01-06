<?php

namespace App\Containers\AppSection\Deal\Data\Criterias;

use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class OfferByCriteria extends Criteria
{
    private int $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where('offer_by', '=', $this->user_id);
    }
}
