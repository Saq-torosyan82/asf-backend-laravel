<?php

namespace App\Containers\AppSection\Payment\Tasks;

use App\Containers\AppSection\Payment\Data\Repositories\PaymentRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetPaymentsByDealIdTask extends Task
{
    protected PaymentRepository $repository;

    /**
     * @param PaymentRepository $repository
     */
    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $deal_id
     * @return mixed
     * @throws NotFoundException
     */
    public function run($deal_id)
    {
        try {
            return $this->repository->findByField('deal_id', $deal_id);
        }
        catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
