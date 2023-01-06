<?php

namespace App\Containers\AppSection\Financial\Actions;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Financial\Tasks\CreateFinancialDocumentTask;
use App\Containers\AppSection\Financial\Tasks\GetActualFinancialTask;
use App\Containers\AppSection\Upload\Tasks\ForceDeleteUploadTask;
use App\Ship\Exceptions\ConflictException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class SubmitFinancialDocumentsAction extends Action
{
    use HashIdTrait;
    public function run(Request $request)
    {
        $files = $request->filesIds;
        $docsIds = [];
        if ($files) {
            $actual = app(GetActualFinancialTask::class)->run($request->club_id);

            if ($actual == null) {
                foreach ($files as $file) {
                    app(ForceDeleteUploadTask::class)->run($this->decode($file));
                }

                throw new ConflictException("Actual financial not found.");
            }

            $financialId = $actual->id;
            foreach ($files as $file) {
                $data = [
                    'financial_id' => $financialId,
                    'section_id' => $request->section_id,
                    'upload_id' => $this->decode($file)
                ];
                $finDoc = app(CreateFinancialDocumentTask::class)->run($data);
                $docsIds[] = $this->encode($finDoc->id);
            }

        }
        return $docsIds;
    }
}
