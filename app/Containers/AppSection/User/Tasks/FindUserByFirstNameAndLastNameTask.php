<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindUserByFirstNameAndLastNameTask extends Task
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $firstName, string $lastName)
    {
        try {
            return $this->repository->findWhere([
                'first_name' => $firstName,
                'last_name' => $lastName
            ])->first();
        } catch (Exception $e) {
            throw new NotFoundException();
        }
    }
}
