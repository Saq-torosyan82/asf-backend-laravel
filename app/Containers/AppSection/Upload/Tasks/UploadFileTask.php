<?php

namespace App\Containers\AppSection\Upload\Tasks;

use App\Ship\Parents\Tasks\Task;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Containers\AppSection\Upload\Enums\UploadType;
use App\Ship\Exceptions\BadRequestException;
use Exception;

class UploadFileTask extends Task
{
    public function run(UploadedFile $file, string $uploadType, ?int $userId, $fileNameShouldBeRenamed = true): string
    {
        $fileNameWithoutExtension = preg_replace("/\.[^.]+$/", "", $file->getClientOriginalName());
        if($fileNameShouldBeRenamed) {
            $fileName = $fileNameWithoutExtension . '_' . time() . '.' . $file->getClientOriginalExtension();
        }else {
            $fileName = $file->getClientOriginalName();
        }

        $path = UploadType::GetPathByUploadType($uploadType, $userId);

        try {
            return Storage::putFileAs(
                $path, $file, $fileName
            );
        } catch (Exception $ex) {
            throw new BadRequestException($ex->getMessage());
        }

    }
}
