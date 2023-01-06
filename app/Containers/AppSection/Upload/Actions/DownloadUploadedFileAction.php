<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Containers\AppSection\Upload\Exceptions\FileNotFoundException;
use App\Containers\AppSection\Upload\Tasks\FindUploadByUuidTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Storage;

class DownloadUploadedFileAction extends Action
{
    public function run(Request $request)
    {
        $upload = app(FindUploadByUuidTask::class)->run($request->uuid);

        if (is_null($upload)) {
            throw new FileNotFoundException();
        }

        $headers = array(
            'filemime' => $upload->file_mime,
            'filename' => $upload->init_file_name,
            'Access-Control-Expose-Headers' => ['filename', 'filemime'],
        );

        return Storage::download($upload->file_path, $upload->init_file_name, $headers);
    }
}
