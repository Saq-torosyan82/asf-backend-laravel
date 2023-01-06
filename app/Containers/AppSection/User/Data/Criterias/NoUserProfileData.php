<?php

namespace App\Containers\AppSection\User\Data\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class NoUserProfileData extends Criteria
{
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->doesntHave('UserProfile');
    }
}
