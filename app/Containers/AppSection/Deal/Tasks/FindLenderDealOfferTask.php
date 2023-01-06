<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Data\Repositories\DealOfferRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindLenderDealOfferTask extends Task
{
    protected DealOfferRepository $repository;

    public function __construct(DealOfferRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($deal_id, $lender_id)
    {
        try {
            return $this->repository->findWhere(
                [
                    'deal_id' => $deal_id,
                    'offer_by' => $lender_id
                ]
            )->first();
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
