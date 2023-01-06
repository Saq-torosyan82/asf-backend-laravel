<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Data\Criterias\AcceptedOfferCriteria;
use App\Containers\AppSection\Deal\Data\Criterias\MissedCriteria;
use App\Containers\AppSection\Deal\Data\Criterias\NotRejectedOffersCriteria;
use App\Containers\AppSection\Deal\Data\Criterias\OfferByCriteria;
use App\Containers\AppSection\Deal\Data\Criterias\RejectedCriteria;
use App\Containers\AppSection\Deal\Data\Repositories\DealOfferRepository;
use App\Ship\Criterias\OrderByCreationDateDescendingCriteria;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;

class GetAllLenderMissedDealsTask extends Task
{
    protected DealOfferRepository $repository;

    /**
     * @param DealOfferRepository $repository
     */
    public function __construct(DealOfferRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     * @throws NotFoundException
     */
    public function run($usePagination = true)
    {
        try {
            if ($usePagination) {
                return $this->repository->paginate();
            }else {
                return $this->repository->all();
            }
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }



    /**
     * @return $this
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function rejected(): self
    {
        $this->repository->pushCriteria(new RejectedCriteria());
        return $this;
    }

    /**
     * @param $user_id
     * @return $this
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function offerBy($user_id)
    {
        $this->repository->pushCriteria(new OfferByCriteria($user_id));
        return $this;
    }

    /**
     * @return $this
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function ordered(): self
    {
        $this->repository->pushCriteria(new OrderByCreationDateDescendingCriteria());
        return $this;
    }

    /**
     * @return $this
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function missed(): self
    {
        $this->repository->pushCriteria(new MissedCriteria());
        return $this;
    }
}
