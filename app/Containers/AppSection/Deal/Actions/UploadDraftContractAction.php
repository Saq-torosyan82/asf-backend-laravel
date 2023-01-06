<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Containers\AppSection\Deal\Exceptions\TermsheetNotFoundException;
use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\Deal\Tasks\FindDealByIdTask;
use App\Containers\AppSection\Deal\Tasks\GetAcceptedOfferTask;
use App\Containers\AppSection\Deal\Tasks\UpdateDealTask;
use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\Upload\Actions\UploadFileSubAction;
use App\Containers\AppSection\Upload\Enums\UploadType;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UploadDraftContractAction extends Action
{
    public function run(Request $request): Deal
    {
        // get deal
        $deal = app(FindDealByIdTask::class)->run($request->id);

        // upload document
        $upload = app(UploadFileSubAction::class)->run($request->file('file'), UploadType::CONTRACT, $deal->user_id);

        $data = [];

        $extra_data = [];
        if ($deal->extra_data && is_array($deal->extra_data)) {
            $extra_data = $deal->extra_data;
        }

        $crtContract = [
            'id' => $upload->id,
            'uuid' => $upload->uuid,
            'date' => $upload->created_at->format('Y-m-d h:i:s'),
        ];

        if (isset($extra_data['contract'])) {
            if (isset($extra_data['contract']['current'])) {
                if (!isset($extra_data['contract']['history'])) {
                    $extra_data['contract']['history'] = [];
                }

                $extra_data['contract']['history'][] = $extra_data['contract']['current'];
            }

            $extra_data['contract']['current'] = $crtContract;
        } else {
            $extra_data['contract'] = [
                'current' => $crtContract
            ];
        }

        $data['extra_data'] = $extra_data;
        $data['status'] = DealStatus::IN_PROGRESS;
        $data['reason'] = StatusReason::CONTRACT_ISSUED;

        try {
            $res = app(UpdateDealTask::class)->run($request->id, $data);
        } catch (\Exception $e) {
            throw $e;
        }

        // get accepted offer
        $accepted_offer = app(GetAcceptedOfferTask::class)->run($deal->id);
        if (is_null($accepted_offer)) {
            // this shouldn't happen
            return $res;
        }

        // send notification
        try {
            $data = [
                // maybe add more data
                'vars' => [
                    'linkToDeal' => config('appSection-authentication.login_token_redirect') . '/deals?id='.$deal->getHashedKey(),
                    'dealType' => $deal->deal_type,
                    'email' => $deal->user->email,
                    'first_name' => $deal->user->first_name,
                    'last_name' => $deal->user->last_name,
                    'lenderName' => $deal->offers->first()->user->first_name . ' ' . $deal->offers->first()->user->last_name,
                ],
                'lenders_ids' => [$accepted_offer->offer_by]
            ];

            app(NotificationTask::class)->run($deal, MailContext::ADMIN_UPLOADS_CONTRACT, $data);
        } catch (\Exception $e) {
            // silently ignore
        }

        return $res;
    }
}
