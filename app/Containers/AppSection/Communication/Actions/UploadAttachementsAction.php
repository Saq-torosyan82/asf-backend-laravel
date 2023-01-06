<?php

namespace App\Containers\AppSection\Communication\Actions;

use App\Containers\AppSection\Upload\Actions\UploadFileSubAction;
use App\Containers\AppSection\Upload\Enums\UploadType;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;

class UploadAttachementsAction extends Action
{
    public function run(Request $request)
    {
        $uploadRes = [];
        if ($request->file('attachements')) {
            foreach ($request->file('attachements') as $attachement) {
                $upload = app(UploadFileSubAction::class)->run($attachement, UploadType::COMMUNICATION, Auth::user()->id);
                array_push($uploadRes, $upload->toArray());
            }
        }

        return $uploadRes;
    }
}
