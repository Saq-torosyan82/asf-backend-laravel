<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetUsersProfileByKeyAndValueTask extends Task
{
    protected UserProfileRepository $repository;

    public function __construct(UserProfileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $group, string $key, string $value = null)
    {
        $filters = [
            'group' => $group,
            'key' => $key,
        ];
        if ($value) {
            $filters['value'] = $value;
        }

        try {
            return $this->repository->findWhere($filters)->all();
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
