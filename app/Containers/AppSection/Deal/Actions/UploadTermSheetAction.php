<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\OfferStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Containers\AppSection\Deal\Exceptions\TermsheetNotFoundException;
use App\Containers\AppSection\Deal\Mapper\Status;
use App\Containers\AppSection\Deal\Models\DealOffer;
use App\Containers\AppSection\Deal\Tasks\CreateDealOfferTask;
use App\Containers\AppSection\Deal\Tasks\FindDealByIdTask;
use App\Containers\AppSection\Deal\Tasks\FindLenderDealOfferTask;
use App\Containers\AppSection\Deal\Tasks\UpdateDealOfferTask;
use App\Containers\AppSection\Deal\Tasks\UpdateDealTask;
use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\System\Tasks\GetLenderCriteriaForDealTask;
use App\Containers\AppSection\Upload\Actions\UploadFileSubAction;
use App\Containers\AppSection\Upload\Enums\UploadType;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UploadTermSheetAction extends Action
{
    public function run(Request $request): DealOffer
    {
        $user_id = \Auth::id();

        // upload document
        $upload = app(UploadFileSubAction::class)->run($request->file('file'), UploadType::TERM_SHEET, $user_id);

        // create offer


        // check if offer exists
        $offer = app(FindLenderDealOfferTask::class)->run($request->id, $user_id);
        if (is_null($offer)) {
            // create the offer
            $data = [
                'deal_id' => $request->id,
                'offer_by' => $user_id,
                'status' => OfferStatus::NEW,
                'termsheet_id' => $upload->id,
            ];

            $res = app(CreateDealOfferTask::class)->run($data);
        }
        else
        {
            $data = [
                'status' => OfferStatus::NEW,
                'termsheet_id' => $upload->id,
            ];

            $res = app(UpdateDealOfferTask::class)->run($offer->id, $data);
        }

        // get deal
        $deal = app(FindDealByIdTask::class)->run($request->id);
        if (($deal->status == DealStatus::LIVE) && ($deal->reason == StatusReason::APPROVED_ASF)) {
            $data = [
                'reason' => StatusReason::TERMS_UPLOADED,
            ];

            app(UpdateDealTask::class)->run($request->id, $data);
        }


        // send notification
        $data = [
            // maybe add more data
            'vars' => [
                'lenderNames' => '',
                'linkToDeal' => config('appSection-authentication.login_token_redirect') . '/deals?id='.$deal->getHashedKey(),
                'dealType' => $deal->deal_type,
                'email' => $deal->user->email,
                'first_name' => $deal->user->first_name,
                'last_name' => $deal->user->last_name,
            ],
            'lenders_ids' => [$res->offer_by],
            'entity_id' => $res->id
        ];

        $lenders = app(GetLenderCriteriaForDealTask::class)->run($deal);
        if ($lenders) {
            $data['vars']['lenderNames'] = $lenders['lender_names'];
        }

        try {
            app(NotificationTask::class)->run($deal, MailContext::LENDER_UPLOADS_TERM_SHEET, $data);
        } catch (\Exception $e) {
            // silently ignore
        }

        return $res;
    }
}
