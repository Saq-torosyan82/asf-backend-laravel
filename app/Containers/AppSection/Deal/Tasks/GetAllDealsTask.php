<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Data\Criterias\ContractSignedCriteria;
use App\Containers\AppSection\Deal\Data\Criterias\CreatedAtCriteria;
use App\Containers\AppSection\Deal\Data\Criterias\DealLiveCriteria;
use App\Containers\AppSection\Deal\Data\Criterias\FutureCriteria;
use App\Containers\AppSection\Deal\Data\Criterias\LiveCriteria;
use App\Containers\AppSection\Deal\Data\Criterias\NotStartedDealsCriteria;
use App\Containers\AppSection\Deal\Data\Criterias\UserCriteria;
use App\Containers\AppSection\Deal\Data\Criterias\UsersCriteria;
use App\Containers\AppSection\Deal\Data\Repositories\DealRepository;
use App\Ship\Criterias\IdsCriteria;
use App\Ship\Criterias\OrderByCreationDateDescendingCriteria;
use App\Ship\Criterias\PeriodCriteria;
use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;

class GetAllDealsTask extends Task
{
    protected DealRepository $repository;

    public function __construct(DealRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($use_pagination = false)
    {
        if ($use_pagination)
            return $this->repository->with('offers')->with('user')->paginate();

        return $this->repository->with('offers')->with('user')->get();
    }

    public function live(): self
    {
        $this->repository->pushCriteria(new LiveCriteria());
        return $this;
    }

    public function future(): self
    {
        $this->repository->pushCriteria(new FutureCriteria());
        return $this;
    }

    public function notStarted(): self
    {
        $this->repository->pushCriteria(new NotStartedDealsCriteria());
        return $this;
    }

    public function liveDeal(): self
    {
        $this->repository->pushCriteria(new DealLiveCriteria());
        return $this;
    }

    public function contractSigned(): self
    {
        $this->repository->pushCriteria(new ContractSignedCriteria());
        return $this;
    }

    public function ordered(): self
    {
        $this->repository->pushCriteria(new OrderByCreationDateDescendingCriteria());
        return $this;
    }

    public function user($user_id)
    {
        $this->repository->pushCriteria(new UserCriteria($user_id));
        return $this;
    }

    public function users($user_ids)
    {
        $this->repository->pushCriteria(new UsersCriteria($user_ids));
        return $this;
    }

    public function ids($ids)
    {
        $this->repository->pushCriteria(new IdsCriteria($ids));
        return $this;
    }

    public function period()
    {
        $this->repository->pushCriteria(new PeriodCriteria());
        return $this;
    }

    public function createdAt($nb_days): self
    {
        if (!$nb_days) {
            return $this;
        }

        $this->repository->pushCriteria(new CreatedAtCriteria($nb_days));
        return $this;
    }
}
