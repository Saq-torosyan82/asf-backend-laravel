<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateUserProfileTask extends Task
{
    protected UserProfileRepository $repository;

    public function __construct(UserProfileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $userId, string $key, string $group, string $value = null)
    {
        if(!$value){
            return true;
        }

        try {
            return $this->repository->create([
                'user_id' => $userId,
                'key' => $key,
                'group' => $group,
                'value' => $value
            ]);
        }
        catch (Exception $exception) {
            throw new CreateResourceFailedException($exception->getMessage());
        }
    }
}
