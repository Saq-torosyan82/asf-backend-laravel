<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Containers\AppSection\Upload\Actions\UploadFileSubAction;
use App\Containers\AppSection\Upload\Enums\UploadType;
use App\Containers\AppSection\Upload\Tasks\UploadFileTask;
use App\Ship\Parents\Tasks\Task;

class UploadLogoTask extends Task
{
    public function run($logo, $uploadType, $userId)
    {
        if(!$logo) {
            return null;
        }
        app(UploadFileTask::class)->run($logo, $uploadType, $userId, false);
        return $logo->getClientOriginalName();
    }
}
