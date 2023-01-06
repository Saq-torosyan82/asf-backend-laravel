<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Criterias\NewsCountryIdsCriteria;
use App\Containers\AppSection\System\Data\Criterias\NewsLimitCriteria;
use App\Containers\AppSection\System\Data\Criterias\NewsOrderCriteria;
use App\Containers\AppSection\System\Data\Criterias\NewsSportIdsCriteria;
use App\Containers\AppSection\System\Data\Repositories\SportNewsRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetSportNewsTask extends Task
{
    protected SportNewsRepository $repository;

    public function __construct(SportNewsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($use_pagination = false)
    {
        try {
            if ($use_pagination) {
                return $this->repository->paginate();
            } else {
                return $this->repository->get()->toArray();
            }

        }
        catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
    public function order(): self
    {
        $this->repository->pushCriteria(new NewsOrderCriteria());
        return $this;
    }

    public function sportIds($sports): self
    {
        if (!empty($sports)) {
            $this->repository->pushCriteria(new NewsSportIdsCriteria($sports));
        }
        return $this;
    }
    public function countryIds($countries): self
    {
        if (!empty($countries)) {
            $this->repository->pushCriteria(new NewsCountryIdsCriteria($countries));
        }
        return $this;
    }

    public function limit($limit): self
    {
        if ($limit !== null) {
            $this->repository->pushCriteria(new NewsLimitCriteria($limit));
        }
        return $this;
    }
}
