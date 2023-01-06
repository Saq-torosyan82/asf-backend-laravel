<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\System\Data\Repositories\SportNewsRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class SaveSportNewsTask extends Task
{
    protected SportNewsRepository $repository;

    public function __construct(SportNewsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($data)
    {
        $news = $this->repository->where(
            'title', '=', $data['title']
        )->get();
        if ($news->isEmpty()) {
            try {
                return $this->repository->create($data);
            } catch (Exception $exception) {
                throw new CreateResourceFailedException();
            }
        }
    }
}
