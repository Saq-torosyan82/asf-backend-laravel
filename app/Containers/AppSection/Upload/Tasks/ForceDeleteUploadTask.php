<?php

namespace App\Containers\AppSection\Upload\Tasks;

use App\Containers\AppSection\Upload\Data\Repositories\UploadRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use Illuminate\Support\Facades\Storage;
use App\Ship\Parents\Tasks\Task;
use Exception;

class ForceDeleteUploadTask extends Task
{
    protected UploadRepository $repository;

    public function __construct(UploadRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id): ?int
    {
        try {
            $upload = $this->repository->findByField('id', $id)->first();
            
            if($upload == null) return false;

            // Delete file from disk    
            Storage::delete($upload->file_path);

            // Delete entry from db
            return $upload->forceDelete($id);
        }
        catch (Exception $exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
