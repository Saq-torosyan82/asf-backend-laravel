<?php

namespace App\Containers\AppSection\System\Data\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class NewsCountryIdsCriteria extends Criteria
{
    private array $countries;

    public function __construct($countries)
    {
        $this->countries = $countries;
    }
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->whereIn('country_id', $this->countries);
    }
}
