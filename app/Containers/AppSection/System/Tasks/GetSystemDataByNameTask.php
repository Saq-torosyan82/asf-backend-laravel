<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportBrandRepository;
use App\Containers\AppSection\System\Data\Repositories\SportClubRepository;
use App\Containers\AppSection\System\Data\Repositories\SportSponsorRepository;
use App\Ship\Parents\Repositories\Repository;
use App\Ship\Parents\Tasks\Task;

class GetSystemDataByNameTask extends Task
{
    public function run(Repository $repository, string $name)
    {
        return $repository->where('name', $name)->first();
    }
}
