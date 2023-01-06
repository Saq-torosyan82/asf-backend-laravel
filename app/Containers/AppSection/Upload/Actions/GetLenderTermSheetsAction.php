<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Containers\AppSection\Deal\Tasks\GetAllLenderOffersTask;
use App\Containers\AppSection\UserProfile\Tasks\GetBorrowerNameTask;
use App\Ship\Parents\Actions\Action;

class GetLenderTermSheetsAction extends Action
{
    public function run($user_id)
    {
        $offers = app(GetAllLenderOffersTask::class)->offerBy($user_id)->ordered()->run();

        $data = [];
        foreach ($offers as $row) {
            $data[] = [
                'label' => 'Termsheet Deal', // SEEMEk: add name
                'borrower_name' => app(GetBorrowerNameTask::class)->run($row->deal->user),
                'status' => $row->status,
                'url' => downloadUrl($row->termsheet->uuid),
                'file_type' => $row->termsheet->file_mime,
                'file_name' => $row->termsheet->file_name,
                'file_size' => $row->termsheet->file_size,
            ];
        }

        return $data;
    }
}
