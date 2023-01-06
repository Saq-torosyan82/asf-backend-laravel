<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\Deal\Exceptions\BorrowerDidntSignedContractException;
use App\Containers\AppSection\Deal\Exceptions\ConflictOfferStatusException;
use App\Containers\AppSection\Deal\Exceptions\ContractAlreadySignedException;
use App\Containers\AppSection\Deal\Exceptions\ForbiddenOfferStatusException;
use App\Containers\AppSection\Deal\Exceptions\MissingContractException;
use App\Containers\AppSection\Deal\Exceptions\UnknownStatusForUpdateException;
use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\Deal\Tasks\GetAcceptedOfferTask;
use App\Containers\AppSection\Deal\Tasks\UpdateDealTask;
use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Containers\AppSection\Deal\Tasks\FindDealByIdTask;
use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\Payment\Actions\CreateDealPaymentsAction;
use App\Containers\AppSection\Upload\Actions\UploadContractSubAction;
use App\Containers\AppSection\Upload\Enums\UploadType;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Requests\Request;

class SignContractAction extends Action
{
    public function run(Request $request): Deal
    {
        $data = $request->sanitizeInput(
            [
                'status',
                'signature',
            ]
        );

        $borrowerKey = 'borrower-signature';
        $lenderKey = 'lender-signature';

        $deal = app(FindDealByIdTask::class)->run($request->id);

        $extra_data = $deal->extra_data;
        if (!isset($extra_data['contract'])) {
            throw new MissingContractException();
        }

        $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->input('signature')));

        $extra_data_key = '';
        $dealData = [];
        $notification_ctx = '';
        if ($data['status'] == self::BORROWER_SIGNED_CONTRACT()) {
            if ($deal->status != DealStatus::IN_PROGRESS || $deal->reason != StatusReason::CONTRACT_ISSUED) {
                throw new ConflictOfferStatusException();
            }

            // check if already signed
            if (isset($extra_data['contract'][$borrowerKey])) {
                throw new ContractAlreadySignedException('contract already signed by the borrower');
            }

            $extra_data_key = $borrowerKey;

            // user should be borrower
            $user = \Auth::user();
            $isBorrower = $user->roles->where('name', PermissionType::BORROWER)->first();
            if (!$isBorrower) {
                throw new ForbiddenOfferStatusException();
            }

            // upload signature
            try {
                $upload = app(UploadContractSubAction::class)->run(
                    $file,
                    UploadType::BORROWER_SIGNATURE,
                    $deal->user_id
                );
            } catch (Exception $e) {
                throw $e;
            }

            $dealData['reason'] = StatusReason::SIGNED_BORROWER;
            $dealData['status'] = DealStatus::ACCEPTED;
            $notification_ctx = MailContext::BORROWER_SIGNED_CONTRACT;
        } elseif ($data['status'] == self::LENDER_SIGNED_CONTRACT()) {
            if ($deal->status != DealStatus::ACCEPTED || $deal->reason != StatusReason::SIGNED_BORROWER) {
                throw new ConflictOfferStatusException();
            }

            // check if borrower signed contract
            if (!isset($extra_data['contract'][$borrowerKey])) {
                throw new BorrowerDidntSignedContractException();
            }

            // check if already signed by the lender
            if (isset($extra_data['contract'][$lenderKey])) {
                throw new ContractAlreadySignedException('contract already signed by the lender');
            }

            $extra_data_key = $lenderKey;

            // user should be borrower
            $user = \Auth::user();
            $isLender = $user->roles->where('name', PermissionType::LENDER)->first();
            if (!$isLender) {
                throw new ForbiddenOfferStatusException();
            }

            // upload signature
            try {
                $upload = app(UploadContractSubAction::class)->run(
                    $file,
                    UploadType::LENDER_SIGNATURE,
                    $deal->user_id
                );
            } catch (Exception $e) {
                throw $e;
            }

            $dealData['reason'] = StatusReason::CONTRACT_SIGNED;
            $dealData['status'] = DealStatus::STARTED;
            $notification_ctx = MailContext::LENDER_SIGNED_CONTRACT;
        } else {
            throw new UnknownStatusForUpdateException();
        }

        $extra_data['contract'][$extra_data_key] = [
            'id' => $upload->id,
            'uuid' => $upload->uuid,
            'date' => $upload->created_at
        ];

        $dealData['extra_data'] = $extra_data;

        try {
            $res = app(UpdateDealTask::class)->run($request->id, $dealData);
        }
        catch (\Exception  $e){
            throw $e;
        }

        if ($data['status'] == self::LENDER_SIGNED_CONTRACT()) {
            // add installments to payments table
            try {
                app(CreateDealPaymentsAction::class)->run($deal);
            } catch (Exception $e) {
                // silently ignore
                // if this call will crash, there is another cron that will add data to table
            }
        }

        // get accepted offer
        $accepted_offer = app(GetAcceptedOfferTask::class)->run($deal->id);
        if (is_null($accepted_offer)) {
            // this shouldn't happen
            return $res;
        }

        // get lender
        try {
            $data = [
                // maybe add more data
                'vars' => [
                    'email' => $deal->user->email,
                    'linkToDeal' => config('appSection-authentication.login_token_redirect') . '/deals?id='.$deal->getHashedKey(),
                    'dealType' => $deal->deal_type,
                    'lenderName' => $deal->offers->first()->user->first_name . ' ' . $deal->offers->first()->user->last_name,
                    'first_name' => $deal->user->first_name,
                    'last_name' => $deal->user->last_name,
                ],
                'lenders_ids' => [$accepted_offer->offer_by]
            ];

            app(NotificationTask::class)->run($deal, $notification_ctx, $data);

            if($notification_ctx == MailContext::LENDER_SIGNED_CONTRACT) {
                app(NotificationTask::class)->run($deal, MailContext::DEAL_STATUS_CHANGED_TO_STARTED, $data);
            }
        } catch (\Exception $e) {
            // silently ignore
        }

        return $res;
    }

    private static function BORROWER_SIGNED_CONTRACT()
    {
        return 'borrower_signed_contract';
    }

    private static function LENDER_SIGNED_CONTRACT()
    {
        return 'lender_signed_contract';
    }
}
