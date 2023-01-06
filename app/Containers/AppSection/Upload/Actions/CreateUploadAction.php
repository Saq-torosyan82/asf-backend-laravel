<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Ship\Parents\Exceptions\Exception\NotFoundException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class CreateUploadAction extends Action
{
    public function run(Request $request)
    {
        if($request->user_id == []) throw new NotFoundException();
        $userId = $request->user_id == null ? $request->user()->id : $request->user_id;

        $upload = app(UploadFileSubAction::class)->run($request->file('file'), $request->upload_type, $userId);

        return $upload->uuid;
    }
}
