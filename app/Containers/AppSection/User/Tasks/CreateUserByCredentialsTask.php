<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\Hash;

class CreateUserByCredentialsTask extends Task
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(
        bool $isAdmin,
        string $email,
        string $password,
        string $first_name = null,
        string $last_name = null,
        string $gender = null,
        string $birth = null,
        bool $isLocked = false,
        int $parentId = null
    ): User
    {
        try {
            // create new user
            $user = $this->repository->create([
                'password' => Hash::make($password),
                'email' => $email,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'gender' => $gender,
                'birth' => $birth,
                'is_admin' => $isAdmin,
                'is_locked' => $isLocked,
                'parent_id' => $parentId
            ]);

        } catch (Exception $e) {
            throw new CreateResourceFailedException();
        }

        return $user;
    }
}
