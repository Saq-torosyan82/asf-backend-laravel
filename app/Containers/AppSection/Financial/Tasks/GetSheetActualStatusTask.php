<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Enums\FinancialDocumentsStatus;
use App\Ship\Parents\Tasks\Task;

class GetSheetActualStatusTask extends Task
{
    public function run($user_id, $club_id)
    {
        $actualStatusesBySheet = [];
        $actualStatuses = [];
        $docs = app(GetUserFinancialDocumentsTask::class)->run($user_id, $club_id);
        if (!empty($docs)) {
            foreach ($docs as $doc) {
                $actualStatusesBySheet[$doc->label][] = $doc->status;
            }
            foreach ($actualStatusesBySheet as $sheet => $statuses) {
                if (in_array(FinancialDocumentsStatus::ACCEPTED, $statuses)) {
                    $actualStatuses[$sheet] = FinancialDocumentsStatus::getActualStatus(FinancialDocumentsStatus::ACCEPTED);
                } elseif (in_array(FinancialDocumentsStatus::PENDING, $statuses)) {
                    $actualStatuses[$sheet] = FinancialDocumentsStatus::getActualStatus(FinancialDocumentsStatus::PENDING);
                } elseif (in_array(FinancialDocumentsStatus::UPLOADED, $statuses)) {
                    $actualStatuses[$sheet] = FinancialDocumentsStatus::getActualStatus(FinancialDocumentsStatus::UPLOADED);
                } else {
                    $actualStatuses[$sheet] = FinancialDocumentsStatus::getActualStatus(FinancialDocumentsStatus::REJECTED);
                }
            }
        }
        return $actualStatuses;
    }
}
