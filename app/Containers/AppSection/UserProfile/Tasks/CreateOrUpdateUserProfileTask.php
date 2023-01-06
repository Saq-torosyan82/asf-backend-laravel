<?php

namespace App\Containers\AppSection\UserProfile\Tasks;

use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateOrUpdateUserProfileTask extends Task
{
    protected UserProfileRepository $repository;

    public function __construct(UserProfileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($userId, $group, $key, $data)
    {
        try {
            return $this->repository->updateOrCreate([
                'user_id' => $userId,
                'group'   => $group,
                'key'     => $key
            ], [
                'value' => $data
            ]);
        }
        catch (Exception $exception) {
            throw new Exception('Failed to create/update resource');
        }
    }
}
