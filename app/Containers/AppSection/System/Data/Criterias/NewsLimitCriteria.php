<?php

namespace App\Containers\AppSection\System\Data\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class NewsLimitCriteria extends Criteria
{
    private int $limit;

    public function __construct($limit)
    {
        $this->limit = $limit;
    }
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->limit($this->limit);
    }
}
