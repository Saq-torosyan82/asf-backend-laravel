<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\LenderDealCriterionCurrencyRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateLenderDealCriterionCurrencyTask extends Task
{
    protected LenderDealCriterionCurrencyRepository $repository;

    public function __construct(LenderDealCriterionCurrencyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($criterion_id, $values)
    {
        try {
            // get existing values
            $res = $this->repository->findWhere(['criterion_id' => $criterion_id]);
            $cData = [];
            foreach ($res as $row) {
                $cData[$row->currency_id] = 1;
            }

            // check if value exists
            foreach ($values as $row) {
                // skip if value exists
                if (isset($cData[$row['id']])) {
                    unset($cData[$row['id']]);
                    continue;
                }

                // save new value
                app(CreateLenderDealCriterionCurrencyTask::class)->run($criterion_id, $row['id']);
            }

            // delete ramained countries
            foreach ($cData as $key => $unit) {
                $this->repository->deleteWhere(['criterion_id' => $criterion_id, 'currency_id' => $key]);
            }

            return true;
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
