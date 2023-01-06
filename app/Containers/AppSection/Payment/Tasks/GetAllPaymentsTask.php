<?php

namespace App\Containers\AppSection\Payment\Tasks;

use App\Containers\AppSection\Payment\Data\Repositories\PaymentRepository;
use App\Ship\Parents\Tasks\Task;

class GetAllPaymentsTask extends Task
{
    protected PaymentRepository $repository;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->repository->paginate();
    }
}
