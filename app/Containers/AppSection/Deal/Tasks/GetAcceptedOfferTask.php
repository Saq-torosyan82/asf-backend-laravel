<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Data\Criterias\AcceptedOfferCriteria;
use App\Containers\AppSection\Deal\Data\Criterias\CurrentCriteria;
use App\Containers\AppSection\Deal\Data\Criterias\NotRejectedOffersCriteria;
use App\Containers\AppSection\Deal\Data\Criterias\OfferByCriteria;
use App\Containers\AppSection\Deal\Data\Repositories\DealOfferRepository;
use App\Containers\AppSection\Deal\Enums\OfferStatus;
use App\Ship\Criterias\OrderByCreationDateDescendingCriteria;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetAcceptedOfferTask extends Task
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
    public function run($deal_id)
    {
        try {
            return $this->repository->findWhere(
                [
                    'deal_id' => $deal_id,
                    'status' => OfferStatus::ACCEPTED
                ]
            )->first();
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
