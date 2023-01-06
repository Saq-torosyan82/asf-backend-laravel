<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateUserProfileTask extends Task
{
    protected UserProfileRepository $repository;

    public function __construct(UserProfileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id, $value)
    {
        try {
            return $this->repository->update([
                'value' => $value
            ], $id);
        }
        catch (Exception $exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
