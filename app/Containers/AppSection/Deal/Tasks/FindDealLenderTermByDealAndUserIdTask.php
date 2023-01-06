<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Data\Repositories\LenderTermRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindDealLenderTermByDealAndUserIdTask extends Task
{
    protected LenderTermRepository $repository;

    public function __construct(LenderTermRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $deal_id, int $user_id)
    {
        try {
            return $this->repository->findWhere([
                'deal_id' => $deal_id,
                'user_id' => $user_id
            ])->first();
        }
        catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
