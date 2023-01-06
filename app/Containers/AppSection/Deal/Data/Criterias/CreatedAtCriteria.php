<?php

namespace App\Containers\AppSection\Deal\Data\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Carbon\Carbon;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class CreatedAtCriteria extends Criteria
{
    private int $nb_days;

    public function __construct($nb_days)
    {
        $this->nb_days = $nb_days;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->whereDate('created_at', '=', Carbon::now()->subDays($this->nb_days));
    }
}
