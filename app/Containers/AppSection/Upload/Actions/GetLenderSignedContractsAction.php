<?php

namespace App\Containers\AppSection\Upload\Actions;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Containers\AppSection\Deal\Tasks\FindDealByIdTask;
use App\Containers\AppSection\Deal\Tasks\GetAllLenderOffersTask;
use App\Containers\AppSection\Upload\Tasks\FindUploadByIdTask;
use App\Containers\AppSection\UserProfile\Tasks\GetBorrowerNameTask;
use App\Ship\Parents\Actions\Action;

class GetLenderSignedContractsAction extends Action
{
    use HashIdTrait;

    public function run($user_id)
    {
        // get all accepted offers
        $offers = app(GetAllLenderOffersTask::class)->offerBy($user_id)->accepted()->ordered()->run();
        $data = [];
        foreach ($offers as $row) {
            // get deal for the offer
            $deal = app(FindDealByIdTask::class)->run($row->deal_id);
            if (is_null($deal)) {
                continue;
            }

            // skip if contract is not signed
            if (($deal->status != DealStatus::STARTED) || ($deal->reason != StatusReason::CONTRACT_SIGNED)) {
                continue;
            }

            $contract = $deal->extra_data['contract']['current'];
            // get file by id
            $upload = app(FindUploadByIdTask::class)->run($contract['id']);
            if (is_null($upload)) {
                continue;
            }

            $data[] = [
                'id' => $this->encode($contract['id']),
                'label' => 'Contract Deal', // SEEMEk: add name
                'borrower_name' => app(GetBorrowerNameTask::class)->run($deal->user),
                'url' => downloadUrl($contract['uuid']),
                'file_type' => $upload->file_mime,
                'file_name' => $upload->file_name,
                'file_size' => $upload->file_size,
            ];
        }

        return $data;
    }
}
