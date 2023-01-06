<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\Deal\Tasks\FindDealByIdTask;
use App\Containers\AppSection\Deal\Tasks\UpdateDealTask;
use App\Containers\AppSection\Upload\Actions\UploadFileSubAction;
use App\Containers\AppSection\Upload\Enums\UploadType;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UploadCreditAnalysisAction extends Action
{
    public function run(Request $request): Deal
    {
        // get deal
        $deal = app(FindDealByIdTask::class)->run($request->id);

        // upload document
        $upload = app(UploadFileSubAction::class)->run(
            $request->file('file'),
            UploadType::CREDIT_ANALYSIS,
            $deal->user_id
        );

        $data = [];

        $extra_data = [];
        if ($deal->extra_data && is_array($deal->extra_data)) {
            $extra_data = $deal->extra_data;
        }

        $extra_data['credit_analysis'] = [
            'id' => $upload->id,
            'uuid' => $upload->uuid,
            'date' => $upload->created_at->format('Y-m-d h:i:s'),
        ];

        $data['extra_data'] = $extra_data;

        return app(UpdateDealTask::class)->run($request->id, $data);
    }
}
