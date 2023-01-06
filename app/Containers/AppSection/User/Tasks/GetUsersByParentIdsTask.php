<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Criterias\AdminsCriteria;
use App\Containers\AppSection\User\Data\Criterias\ClientsCriteria;
use App\Containers\AppSection\User\Data\Criterias\RoleCriteria;
use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Ship\Criterias\OrderByCreationDateDescendingCriteria;
use App\Ship\Parents\Tasks\Task;

class GetUsersByParentIdsTask extends Task
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($user_ids)
    {
        return $this->repository->findWhereIn('parent_id', $user_ids);
    }
}
