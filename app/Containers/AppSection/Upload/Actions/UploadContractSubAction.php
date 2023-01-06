<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Containers\AppSection\Upload\Tasks\CreateUploadTask;
use App\Containers\AppSection\Upload\Tasks\UploadFileTask;
use App\Containers\AppSection\Upload\Enums\UploadType;
use App\Ship\Exceptions\BadRequestException;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Http\UploadedFile;
use App\Ship\Exceptions\ConflictException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadContractSubAction extends SubAction
{
    public function run(string $file_content, string $uploadType, int $userId)
    {
        if (($uploadType != UploadType::LENDER_SIGNATURE) && ($uploadType != UploadType::BORROWER_SIGNATURE)) {
            throw new ConflictException('The upload type must be only signature');
        }

        $fileNameWithoutExtension = ($uploadType == UploadType::LENDER_SIGNATURE) ? 'lender-signature' : 'borrower-signature';
        $newFileName = $fileNameWithoutExtension . '_' . time() . '.png';
        $initFileName = $newFileName . '.png';

        $path = UploadType::GetPathByUploadType($uploadType, $userId);

        try {
            $storage = Storage::put(
                $path . '/' .$newFileName, $file_content
            );

            return app(CreateUploadTask::class)->run([
                'privacy' => UploadType::DETAILS[$uploadType]['privacy'],
                'user_id' => $userId,
                'uploaded_by' => Auth::user()->id,
                'init_file_name' => $initFileName,
                'file_mime' => 'image/png',
                'file_size' => strlen($file_content),
                'file_name' => $newFileName,
                'file_path' => $path
            ]);
        } catch (Exception $ex) {
            throw new BadRequestException('Failed to upload the file');
        }
    }
}
