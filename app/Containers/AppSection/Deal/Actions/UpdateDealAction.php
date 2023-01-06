<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\Deal\Tasks\FindDealByIdTask;
use App\Containers\AppSection\Deal\Tasks\UpdateDealTask;
use App\Containers\AppSection\Deal\Tasks\MapRequestToDealTask;
use App\Containers\AppSection\Upload\Enums\UserDocumetType;
use App\Containers\AppSection\Upload\Exceptions\DealNotFoundException;
use App\Containers\AppSection\Upload\Tasks\GetUserDocumentsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use App\Ship\Exceptions\NotFoundException;

class UpdateDealAction extends Action
{
    public function run(Request $request): Deal
    {
        if ($request->id == []) {
            throw new NotFoundException();
        }

        $dealData = app(MapRequestToDealTask::class)->run($request->all(), false);

        // get deal id
        $deal = app(FindDealByIdTask::class)->run($request->id);
        if (is_null($deal)) {
            throw new DealNotFoundException();
        }

        // SEEMEk: check the permission

        // get user documents
        if ($request->has('docs_ready') && $request->docs_ready) {

            $userDocuments = app(GetUserDocumentsTask::class)->run($deal->user_id);
            if (!$dealData['user_documents']) {
                $dealData['user_documents'] = [];
            }
            foreach ($userDocuments as $row) {
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
            }
        }

        return app(UpdateDealTask::class)->run($request->id, $dealData);
    }
}
