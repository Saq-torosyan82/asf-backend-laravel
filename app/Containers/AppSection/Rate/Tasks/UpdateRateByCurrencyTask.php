<?php

namespace App\Containers\AppSection\Rate\Tasks;

use App\Containers\AppSection\Rate\Data\Repositories\RateRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateRateByCurrencyTask extends Task
{
    protected RateRepository $repository;

    public function __construct(RateRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $data
     * @return void
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function run($data)
    {
        foreach ($data as $key => $value) {
            try {
                $data = ['currency' => $key, 'value' => $value];

                $currency = $this->repository->findByField('currency', $key)->first();

                if ($currency) {
                    $this->repository->update($data, $currency->id);
                } else {
                    $this->repository->create($data);
                }
            } catch (Exception $exception) {
                throw $exception;
            }
        }
    }
}
