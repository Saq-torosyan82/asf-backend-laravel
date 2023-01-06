<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DisableUserAccountTask extends Task
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $id)
    {
        try {
            return $this->repository->update([
                'is_active' => false
            ], $id);
        }
        catch (ModelNotFoundException $exception) {
            throw new NotFoundException('User Not Found.');
        }
        catch (Exception $exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
