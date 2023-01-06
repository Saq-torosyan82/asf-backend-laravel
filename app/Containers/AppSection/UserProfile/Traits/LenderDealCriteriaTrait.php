<?php

namespace App\Containers\AppSection\UserProfile\Traits;

use App\Containers\AppSection\UserProfile\Tasks\FindLenderDealCriteriaByIdTask;

trait LenderDealCriteriaTrait
{
    public function hasLenderCriteria(): bool
    {
        $user = $this->user();
        $userId = $user->id;
        if ($user->isAdmin()) {
            if (!$this->user_id) {
                return false;
            }
            $userId = $this->user_id;
        }

        $lenderCriteria = app(FindLenderDealCriteriaByIdTask::class)->run($this->lender_deal_criteria_id);
        if (is_null($lenderCriteria)) {
            return false;
        }

        return $lenderCriteria->lender_id == $userId;
    }
}
