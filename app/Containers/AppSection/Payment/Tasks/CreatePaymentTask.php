<?php

namespace App\Containers\AppSection\Payment\Tasks;

use App\Containers\AppSection\Payment\Data\Repositories\PaymentRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreatePaymentTask extends Task
{
    protected PaymentRepository $repository;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $data)
    {
        try {
            return $this->repository->create($data);
        }
        catch (Exception $exception) {
            throw new CreateResourceFailedException($exception);
        }
    }
}
