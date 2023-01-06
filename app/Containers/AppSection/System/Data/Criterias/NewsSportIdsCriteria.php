<?php

namespace App\Containers\AppSection\System\Data\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class NewsSportIdsCriteria extends Criteria
{
    private array $sports;

    public function __construct($sports)
    {
        $this->sports = $sports;
    }
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->whereIn('sport_id', $this->sports);
    }
}
