<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Containers\AppSection\Upload\Tasks\CreateUploadTask;
use App\Containers\AppSection\Upload\Tasks\UploadFileTask;
use App\Containers\AppSection\Upload\Enums\UploadType;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Http\UploadedFile;
use App\Ship\Exceptions\ConflictException;
use Illuminate\Support\Facades\Auth;

class UploadFileSubAction extends SubAction
{
    public function run(UploadedFile $file, string $uploadType, int $userId)
    {
        if(!UploadType::hasValue($uploadType)) {
            throw new ConflictException('The upload type is invalid!');
        }


        $filePath = app(UploadFileTask::class)->run($file, $uploadType, $userId);
        $newFileName = basename($filePath);

        return app(CreateUploadTask::class)->run([
            'privacy' => UploadType::DETAILS[$uploadType]['privacy'],
            'user_id' => $userId,
            'uploaded_by' => Auth::user()->id,
            'init_file_name' => $file->getClientOriginalName(),
            'file_mime' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'file_name' => $newFileName,
            'file_path' => $filePath
        ]);
    }
}
