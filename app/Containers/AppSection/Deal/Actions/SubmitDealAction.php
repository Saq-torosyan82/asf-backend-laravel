<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\Deal\Tasks\FindDealByIdTask;
use App\Containers\AppSection\Deal\Tasks\UpdateDealTask;
use App\Containers\AppSection\Deal\Tasks\MapRequestToDealTask;
use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\Upload\Enums\UserDocumetType;
use App\Containers\AppSection\Upload\Exceptions\DealNotFoundException;
use App\Containers\AppSection\Upload\Tasks\GetRequiredUserDocumentsTask;
use App\Containers\AppSection\Upload\Tasks\GetUserDocumentsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use App\Ship\Exceptions\NotFoundException;

class SubmitDealAction extends Action
{
    public function run(Request $request): Deal
    {
        if ($request->id == []) {
            throw new NotFoundException();
        }

        $dealData = app(MapRequestToDealTask::class)->run($request->all(), true);
        // get deal id
        $deal = app(FindDealByIdTask::class)->run($request->id);
        if (is_null($deal)) {
            throw new DealNotFoundException();
        }

        // SEEMEk: check the permission

        // get user documents
        $userDocuments = app(GetUserDocumentsTask::class)->run($deal->user_id);
        if (!$dealData['user_documents']) {
            $dealData['user_documents'] = [];
        }

        // get all needed documents
        $requiredDocuments = app(GetRequiredUserDocumentsTask::class)->run($dealData['contract_type']);

        foreach ($userDocuments as $row) {
            if (!isset($requiredDocuments[$row->type])) {
                continue;
            }
            $is_multiple = UserDocumetType::isMultipleDocument($row->type);

            if (!$is_multiple) {
                $dealData['user_documents'][$row->type] = [
                    'is_multiple' => $is_multiple,
                    'id' => $row->id,
                    'uuid' => $row->uuid,
                    'upload_id' => $row->upload_id,
                    'upload_uuid' => $row->Upload->uuid,
                    'is_verified' => $row->is_verified,
                    'upload_date' => $row->Upload->created_at->format('Y-m-d'),
                ];
            } else {
                if (!isset($dealData['user_documents'][$row->type])) {
                    $dealData['user_documents'][$row->type] = [
                        'is_multiple' => $is_multiple,
                        'data' => [],
                    ];
                }

                $dealData['user_documents'][$row->type]['data'][] = [
                    'id' => $row->id,
                    'uuid' => $row->uuid,
                    'upload_id' => $row->upload_id,
                    'upload_uuid' => $row->Upload->uuid,
                    'is_verified' => $row->is_verified,
                    'upload_date' => $row->Upload->created_at->format('Y-m-d'),
                ];
            }

            unset($requiredDocuments[$row->type]);
        }

        if (($deal->status == DealStatus::NOT_STARTED) && ($deal->reason == StatusReason::DRAFT) && !count(
                $requiredDocuments
            )) {
            $dealData['reason'] = StatusReason::SUBMITTED;

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

            app(NotificationTask::class)->run($deal, MailContext::BORROWER_SUBMITS_DEAL, $data);
        }

        // set new status
        if (!count($requiredDocuments)) {
            $dealData['status'] = DealStatus::IN_PROGRESS;
        }
        $dealData['submited_data'] = $request->all();

        return app(UpdateDealTask::class)->run($request->id, $dealData);
    }
}
