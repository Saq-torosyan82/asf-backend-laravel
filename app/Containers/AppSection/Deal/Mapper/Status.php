<?php

namespace App\Containers\AppSection\Deal\Mapper;


use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;

class Status
{

    const REASON_MAP = [
        DealStatus::NOT_STARTED => [
            StatusReason::DRAFT => 1,
            StatusReason::MISSING_DOCUMENTS => 1,
            StatusReason::CANCELED => 1,
        ],
        DealStatus::IN_PROGRESS => [
            StatusReason::SUBMITTED => 1,
            StatusReason::UNDER_REVIEW => 1,
            StatusReason::TERMS_UPLOADED => 1,
            StatusReason::TERMS_REVIEW => 1,
            StatusReason::TERMS_SIGNED_BORROWER => 1,
        ],
        DealStatus::REJECTED => [
            StatusReason::REJECTED_ASF => 1,
            StatusReason::REJECTED_BORROWER => 1,
            StatusReason::REJECTED_LENDER => 1,
        ],
        DealStatus::ACCEPTED => [
            StatusReason::ACCEPTED_ASF => 1,
            StatusReason::ACCEPTED_BORROWER => 1,
        ],
        DealStatus::LIVE => [
            StatusReason::APPROVED_ASF => 1,
        ],
        DealStatus::STARTED => [
            StatusReason::CONTRACT_SIGNED => 1,
        ],
        DealStatus::COMPLETED => [
            StatusReason::PAYMENT_DONE => 1,
        ]
    ];

    // get available statuses based on the current status
    public static function getAvailableStatuses($status)
    {
        switch ($status) {
            case DealStatus::NOT_STARTED:
                return [DealStatus::IN_PROGRESS => 1];
            case DealStatus::IN_PROGRESS:
                return [DealStatus::ACCEPTED => 1, DealStatus::REJECTED => 1];
            case DealStatus::REJECTED:
                return [DealStatus::NOT_STARTED => 1];
            case DealStatus::ACCEPTED:
                return [DealStatus::STARTED => 1, DealStatus::COMPLETED => 1];
            case DealStatus::LIVE:
                return [DealStatus::STARTED => 1, DealStatus::COMPLETED => 1];
            case DealStatus::STARTED:
                return [DealStatus::COMPLETED => 1];
            case DealStatus::COMPLETED:
                return [];
        }
    }

    public static function getAvailableStatusesAndReasons($status)
    {
        $available_statuses = self::getAvailableStatuses($status);

        foreach ($available_statuses as $k => $v) {
            $available_statuses[$k] = self::REASON_MAP[$k];
        }

        return $available_statuses;
    }

    public static function canChangeStatus($current_status, $new_status)
    {
        $available_statuses = self::getAvailableStatuses($current_status);

        return isset($available_statuses[$new_status]);
    }

    public static function isValidReason($status, $reason)
    {
        return isset(self::REASON_MAP[$status]) && isset(self::REASON_MAP[$status][$reason]);
    }
}
