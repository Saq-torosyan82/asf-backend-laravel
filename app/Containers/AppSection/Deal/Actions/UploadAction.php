<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Enums\DealUpload;
use App\Containers\AppSection\Deal\Exceptions\TermsheetNotFoundException;
use App\Containers\AppSection\Deal\Exceptions\UploadNotFoundException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UploadAction extends Action
{
    public function run(Request $request)
    {
        if (!$request->hasFile('file')) {
            throw new UploadNotFoundException();
        }

        if ($request->upload_type == DealUpload::TERM_SHEET) {
            return app(UploadTermSheetAction::class)->run($request);
        } elseif ($request->upload_type == DealUpload::DRAFT_CONTRACT) {
            return app(UploadDraftContractAction::class)->run($request);
        } elseif ($request->upload_type == DealUpload::CREDIT_ANALYSIS) {
            return app(UploadCreditAnalysisAction::class)->run($request);
        }
    }
}
