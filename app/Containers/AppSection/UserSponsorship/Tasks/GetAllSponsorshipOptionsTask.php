<?php

namespace App\Containers\AppSection\UserSponsorship\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportSponsorRepository;
use App\Containers\AppSection\System\Data\Repositories\SportBrandRepository;
use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Containers\AppSection\UserSponsorship\Enums\Key;
use App\Ship\Parents\Tasks\Task;

class GetAllSponsorshipOptionsTask extends Task
{
    protected $sponsor_repository;
    protected $brand_repository;

    public function __construct(SportSponsorRepository $sponsor, SportBrandRepository $brand)
    {
        $this->sponsor_repository = $sponsor;
        $this->brand_repository = $brand;
    }

    public function run($permission)
    {
        $data = [];

        // get data about sponsors
        $result = $this->sponsor_repository->all();
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->getHashedKey(),
                'name' => $row->name,
                'type' => Key::SPONSOR_TYPE,
            ];
        }

        if ($permission == BorrowerType::CORPORATE) {
            return $data;
        }

        // add data for brands
        $result = $this->brand_repository->all();
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->getHashedKey(),
                'name' => $row->name,
                'type' => Key::BRAND_TYPE,
            ];
        }

        return $data;
    }
}
