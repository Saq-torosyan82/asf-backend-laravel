<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\System\Data\Repositories\SportBrandRepository;
use App\Containers\AppSection\System\Data\Repositories\SportSponsorRepository;
use App\Containers\AppSection\System\Tasks\GetSystemDataByNameTask;
use App\Ship\Parents\Actions\SubAction;

class GetSponsorOrBrandByNameSubAction extends SubAction
{
    protected SportSponsorRepository $sportSponsorRepository;
    protected SportBrandRepository $sportBrandRepository;

    public function __construct(SportSponsorRepository $sportSponsorRepository, SportBrandRepository $sportBrandRepository)
    {
        $this->sportSponsorRepository = $sportSponsorRepository;
        $this->sportBrandRepository = $sportBrandRepository;
    }

    public function run($value)
    {
        $sponsor = app(GetSystemDataByNameTask::class)->run($this->sportSponsorRepository, $value);

        if(!$sponsor) $sponsor = app(GetSystemDataByNameTask::class)->run($this->sportBrandRepository, $value);

        return $sponsor;
    }
}
