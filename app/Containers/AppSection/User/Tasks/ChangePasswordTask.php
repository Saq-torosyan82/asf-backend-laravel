<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Exceptions\NotFoundException;
use Illuminate\Support\Facades\Hash;
use App\Ship\Parents\Tasks\Task;
use Exception;


class ChangePasswordTask extends Task
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }


    public function run(string $email, string $password)
    {
        try {
            $user = $this->repository->findByField('email', $email)->first();
            if($user == null) throw new ModelNotFoundException();

            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundException('User Not Found.');
        } catch (Exception $exception) {
            throw new InternalErrorException();
        }
    }
}
