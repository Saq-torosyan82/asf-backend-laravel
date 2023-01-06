<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\Deal\Exceptions\ConflictOfferStatusException;
use App\Containers\AppSection\Deal\Exceptions\ForbiddenOfferStatusException;
use App\Containers\AppSection\Deal\Exceptions\InvalidUserDocumentStatusException;
use App\Containers\AppSection\Deal\Exceptions\UnknownStatusForUpdateException;
use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\Deal\Tasks\UpdateDealTask;
use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Containers\AppSection\Deal\Tasks\FindDealByIdTask;
use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\System\Tasks\GetLenderCriteriaForDealTask;
use App\Containers\AppSection\Upload\Enums\UserDocumetStatus;
use App\Containers\AppSection\Upload\Tasks\GetUserDocumentsTask;
use App\Containers\AppSection\Upload\Tasks\UpdateUserDocumentTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Requests\Request;

class ChangeDealStatusAction extends Action
{
    public function run(Request $request): Deal
    {
        $data = $request->sanitizeInput(
            [
                'status',
                'reason',
            ]
        );

        $deal = app(FindDealByIdTask::class)->run($request->id);

        // if deal is null -> throw exception

        // SEEMEk: check for permissions

        // seemek: check if new status is correct (based on the current status
        /*
         if (!Status::canChangeStatus($deal->status, $data['status'])) {
            throw new ConflictException("You cannot change the deal to this status!");
        }
         * */

        $dealData = [];
        if ($data['status'] == self::UNDER_REVIEW()) {
            // SEEMEk: check if user is admin and can change the status

            $dealData['reason'] = StatusReason::UNDER_REVIEW;
            return app(UpdateDealTask::class)->run($request->id, $dealData);
        } elseif ($data['status'] == self::REJECT_DOCUMENTS()) {
            // check for message (field reason)

            // SEEMEk: check if user is admin and can change the status

            $extra_data = ($deal->extra_data == '' || !is_array($deal->extra_data)) ? [] : $deal->extra_data;
            if (!isset($extra_data['reject_reasons'])) {
                $extra_data['reject_reasons'] = [];
            }

            $extra_data['reject_reasons'][] = $data['reason'];
            $dealData['extra_data'] = $extra_data;
            $dealData['status'] = DealStatus::NOT_STARTED;
            $dealData['reason'] = StatusReason::REJECTED_ASF;

            try {
                $dealData['user_documents'] = $this->updateUserDocumentStatus($deal, UserDocumetStatus::REJECTED);
            } catch (Exception $e) {
                throw $e;
            }

            // send notification
            $data = [
                // maybe add more data
                'vars' => [
                    'linkToDeal' => config('appSection-authentication.login_token_redirect') . '/deals?id='.$deal->getHashedKey(),
                    'email' => $deal->user->email,
                    'first_name' => $deal->user->first_name,
                    'last_name' => $deal->user->last_name,
                ]
            ];

            app(NotificationTask::class)->run($deal, MailContext::DEAL_DOCUMENTS_REJECTED, $data);

            return app(UpdateDealTask::class)->run($request->id, $dealData);
        } elseif ($data['status'] == self::APPROVE_DOCUMENTS()) {
            $dealData['status'] = DealStatus::LIVE;
            $dealData['reason'] = StatusReason::APPROVED_ASF;

            try {
                $dealData['user_documents'] = $this->updateUserDocumentStatus($deal, UserDocumetStatus::ACCEPTED);
                $res = app(UpdateDealTask::class)->run($request->id, $dealData);
            } catch (Exception $e) {
                throw $e;
            }

            // send notification
            $data = [
                // maybe add more data
                'vars' => [
                    'dealType' => $deal->deal_type,
                    'linkToDeal' => config('appSection-authentication.login_token_redirect') . '/deals?id='.$deal->getHashedKey(),
                    'email' => $deal->user->email,
                    'first_name' => $deal->user->first_name,
                    'last_name' => $deal->user->last_name,
                ]
            ];
            $lenders = app(GetLenderCriteriaForDealTask::class)->run($deal);
            if ($lenders) {
                $data['lenders_ids'] = $lenders['lender_ids'];
            }

            try {
                app(NotificationTask::class)->run($deal, MailContext::DEAL_ACCEPTED, $data);
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }

            return $res;

        } elseif ($data['status'] == self::CANCEL()) {
            $dealData['reason'] = StatusReason::CANCELED;
            $dealData['status'] = DealStatus::NOT_STARTED;

            return app(UpdateDealTask::class)->run($request->id, $dealData);
        }

        throw new UnknownStatusForUpdateException();
    }

    private function updateUserDocumentStatus($deal, $status)
    {
        if (!UserDocumetStatus::hasValue($status)) {
            throw new InvalidUserDocumentStatusException();
        }

        $docIds = [];
        $dealDocuments = [];
        foreach ($deal->user_documents as $type => $row) {
            if ($row['is_multiple'] && isset($row['data']) && is_array($row['data'])) {
                foreach ($row['data'] as $idx => $rrow) {
                    $row['data'][$idx]['is_verified'] = 1;
                    $docIds[$rrow['id']] = 1;
                }
            } else {
                $row['is_verified'] = $status;
                $docIds[$row['id']] = 1;
            }

            $dealDocuments[$type] = $row;
        }

        // update user documents
        $userDocuments = app(GetUserDocumentsTask::class)->run($deal->user_id);
        foreach ($userDocuments as $row) {
            if (!isset($docIds[$row->id])) {
                continue;
            }

            $docData['is_verified'] = $status;
            try {
                $res = app(UpdateUserDocumentTask::class)->run($row->id, $docData);
            } catch (\Exception $e) {
                // SEEMEk: handle error
                continue;
            }
        }

        return $dealDocuments;
    }

    private static function UNDER_REVIEW()
    {
        return "under-review";
    }

    private static function REJECT_DOCUMENTS()
    {
        return 'reject-documents';
    }

    private static function APPROVE_DOCUMENTS()
    {
        return 'approve-documents';
    }

    private static function CANCEL()
    {
        return 'cancel';
    }
}
