<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CheckPasswordSetTask extends Task
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id): bool
    {
        try {
            $user = $this->repository->find($id);
            if(!isset($user->password) || is_null($user->password) || $user->password == '')
                return false;

            return true;
        }
        catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
