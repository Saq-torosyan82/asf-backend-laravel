<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetDealProgressPercentageTask extends Task
{
    public function run($deal)
    {
        if ($deal->status == DealStatus::NOT_STARTED) {
            if ($deal->reason == StatusReason::DRAFT) {
                return 10;
            } elseif ($deal->reason == StatusReason::SUBMITTED) {
                return 30;
            } elseif ($deal->reason == StatusReason::CANCELED) {
                return 0;
            } elseif ($deal->reason == StatusReason::REJECTED_ASF) {
                return 20;
            }
        } elseif ($deal->status == DealStatus::IN_PROGRESS) {
            if ($deal->reason == StatusReason::SUBMITTED) {
                return 30;
            } elseif ($deal->reason == StatusReason::CONTRACT_ISSUED) {
                return 90;
            } elseif ($deal->reason == StatusReason::UNDER_REVIEW) {
                return 40;
            }
        } elseif ($deal->status == DealStatus::LIVE) {
            if ($deal->reason == StatusReason::TERMS_UPLOADED) {
                return 70;
            }
            return 60;
        } elseif ($deal->status == DealStatus::ACCEPTED) {
            if ($deal->reason == StatusReason::ACCEPTED_BORROWER) {
                return 80;
            }
            if ($deal->reason == StatusReason::SIGNED_BORROWER) {
                return 90;
            }
        } elseif ($deal->status == DealStatus::STARTED) {
            if ($deal->reason == StatusReason::CONTRACT_SIGNED)
                return 100;
            return 90;
        } elseif ($deal->status == DealStatus::COMPLETED) {
            return 100;
        }

        return 99; // this shouldn't happen
    }
}
