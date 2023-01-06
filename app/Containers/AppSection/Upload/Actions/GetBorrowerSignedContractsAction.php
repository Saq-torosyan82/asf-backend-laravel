<?php

namespace App\Containers\AppSection\Upload\Actions;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Deal\Tasks\GetAllDealsTask;
use App\Containers\AppSection\Upload\Tasks\FindUploadByIdTask;
use App\Ship\Parents\Actions\Action;

class GetBorrowerSignedContractsAction extends Action
{
    use HashIdTrait;
    public function run($user_id)
    {
        // get all deals with contract signed
        $deals = app(GetAllDealsTask::class)->addRequestCriteria()->user($user_id)->contractSigned()->ordered()->run();

        $data = [];
        foreach ($deals as $row) {
            $contract = $row->extra_data['contract']['current'];
            // get file by id
            $upload = app(FindUploadByIdTask::class)->run($contract['id']);
            if (is_null($upload))
            {
                continue;
            }

            $data[] = [
                'id' => $this->encode($contract['id']),
                'label' => 'Contract Deal', // SEEMEk: add name
                'url' => downloadUrl($contract['uuid']),
                'file_type' => $upload->file_mime,
                'file_name' => $upload->file_name,
                'file_size' => $upload->file_size,
            ];
        }

        return $data;
    }
}
