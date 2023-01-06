<?php

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Carbon\Carbon;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class PeriodCriteria extends Criteria
{
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        $period = config('appSection-deal.last_quotes_period');
        if($period >= 0) {
            return $model->whereDate('created_at', '>=', Carbon::now()->subDays($period));
        }
        return null;
    }
}
