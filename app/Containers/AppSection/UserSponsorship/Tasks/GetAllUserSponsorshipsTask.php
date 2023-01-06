<?php

namespace App\Containers\AppSection\UserSponsorship\Tasks;

use App\Containers\AppSection\UserSponsorship\Data\Repositories\UserSponsorshipRepository;
use App\Ship\Criterias\UserSponsorshiptOrderByTypeCriteria;
use App\Ship\Parents\Tasks\Task;

class GetAllUserSponsorshipsTask extends Task
{
    protected UserSponsorshipRepository $repository;

    public function __construct(UserSponsorshipRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $userId)
    {
        return $this->repository->findWhere([
            'user_id' => $userId
        ]);
    }

    /**
     * @return $this
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function orderByType(): self
    {
        $this->repository->pushCriteria(new UserSponsorshiptOrderByTypeCriteria());
        return $this;
    }
}
