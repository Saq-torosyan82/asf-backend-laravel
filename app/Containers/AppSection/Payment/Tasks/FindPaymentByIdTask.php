<?php

namespace App\Containers\AppSection\Payment\Tasks;

use App\Containers\AppSection\Payment\Data\Repositories\PaymentRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindPaymentByIdTask extends Task
{
    protected PaymentRepository $repository;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id)
    {
        try {
            return $this->repository->find($id);
        }
        catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
