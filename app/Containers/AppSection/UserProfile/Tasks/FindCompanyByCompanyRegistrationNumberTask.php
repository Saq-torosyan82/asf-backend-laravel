<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;

class FindCompanyByCompanyRegistrationNumberTask extends Task
{
    protected UserProfileRepository $repository;

    public function __construct(UserProfileRepository $repository)
    {
        $this->repository = $repository;
    }


    public function run($registrationNumber)
    {
        try {
            $filters = [
                'group' => Group::COMPANY,
                'key' => Key::REGISTRATION_NUMBER,
                'value' => $registrationNumber
            ];

            return $this->repository->findWhere($filters)->all();
        }
        catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
