<?php

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class IdsCriteria extends Criteria
{
    private array $ids;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->whereIn('id', $this->ids);
    }
}
