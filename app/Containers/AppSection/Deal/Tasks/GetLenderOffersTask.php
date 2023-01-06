<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Data\Criterias\AcceptedOfferCriteria;
use App\Containers\AppSection\Deal\Data\Criterias\OfferByCriteria;
use App\Containers\AppSection\Deal\Data\Repositories\DealOfferRepository;
use App\Ship\Criterias\OrderByCreationDateDescendingCriteria;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetLenderOffersTask extends Task
{
    protected DealOfferRepository $repository;

    public function __construct(DealOfferRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        try {
            return $this->repository->with('deal')->get();
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }

    public function accepted(): self
    {
        $this->repository->pushCriteria(new AcceptedOfferCriteria());
        return $this;
    }

    public function offerBy($user_id)
    {
        $this->repository->pushCriteria(new OfferByCriteria($user_id));
        return $this;
    }

    public function ordered(): self
    {
        $this->repository->pushCriteria(new OrderByCreationDateDescendingCriteria());
        return $this;
    }
}
