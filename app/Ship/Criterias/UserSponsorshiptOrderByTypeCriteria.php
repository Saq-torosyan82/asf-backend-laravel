<?php

namespace App\Ship\Criterias;

use App\Containers\AppSection\UserSponsorship\Enums\Key;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class UserSponsorshiptOrderByTypeCriteria extends Criteria
{
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        $orderBy = [
            Key::SHIRT_TYPE,
            Key::SLEEVE_TYPE,
            Key::KIT_TYPE,
            Key::MAIN_PARTNER_TYPE,
            Key::BRAND_TYPE,
            Key::SPONSOR_TYPE,
        ];

        return $model->orderByRaw('FIELD(type, ' . "'" . implode("','", $orderBy) . "'" . ')');
    }
}