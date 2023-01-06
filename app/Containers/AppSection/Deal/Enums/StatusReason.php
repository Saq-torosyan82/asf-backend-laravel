<?php

namespace App\Containers\AppSection\Deal\Enums;

use BenSampo\Enum\Enum;

final class StatusReason extends Enum
{
    // status = not started
    const DRAFT = 'draft';
    const MISSING_DOCUMENTS = 'missing_documents';
    const CANCELED = 'canceled';
    // status = in progress
    const SUBMITTED = 'submitted';
    const UNDER_REVIEW = 'under_review';
    const TERMS_UPLOADED = 'terms_uploaded';
    const TERMS_REVIEW = 'terms_review';
    const TERMS_SIGNED_BORROWER = 'terms_signed_borrower';
    const CONTRACT_ISSUED = 'contract_issued';
    // status = Rejected
    const REJECTED_ASF = 'rejected_asf';
    const REJECTED_BORROWER = 'rejected_borrower';
    const REJECTED_LENDER = 'rejected_lender';
    // status = Accepted
    const ACCEPTED_ASF = 'accepted_asf';
    const ACCEPTED_BORROWER = 'accepted_borrower';
    const SIGNED_BORROWER = 'signed_borrower';

    // status = Live
    const APPROVED_ASF = 'approved_asf';
    // status = Started
    const CONTRACT_SIGNED = 'contract_signed';
    // status = Completed
    const PAYMENT_DONE = 'payment_done';

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::DRAFT:
                return 'Application saved as Draft';
            case self::MISSING_DOCUMENTS:
                return 'Application doesn’t have all necessary documents/data';
            case self::CANCELED:
                return 'Application canceled';

            case self::SUBMITTED:
                return 'Application submitted';
            case self::UNDER_REVIEW:
                return 'Application under review';
            case self::TERMS_UPLOADED:
                return 'Term Sheets uploaded';
            case self::TERMS_REVIEW:
                return 'Term Sheets in review';
            case self::TERMS_SIGNED_BORROWER:
                return 'Term Sheets signed by Borrower';

            case self::REJECTED_ASF:
                return 'Reject by SportsFi';
            case self::REJECTED_BORROWER:
                return 'Reject by Borrower';
            case self::REJECTED_LENDER:
                return 'Reject by Lender';


            case self::ACCEPTED_ASF:
                return 'Accepted by SportsFi';
            case self::ACCEPTED_BORROWER:
                return 'Accepted by Borrower';

            case self::APPROVED_ASF:
                return 'Deal is approved by SportsFi and available for Lenders';

            case self::CONTRACT_ISSUED:
                return 'Draft Contract issued';

            case self::CONTRACT_SIGNED:
                return 'Contract signed by both parties';

            case self::SIGNED_BORROWER:
                return 'Contract signed by borrower';

            case self::PAYMENT_DONE:
                return 'All payments are done';
        }

        return parent::getDescription($value);
    }
}
