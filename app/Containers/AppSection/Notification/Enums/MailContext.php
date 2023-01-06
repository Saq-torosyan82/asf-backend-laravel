<?php

namespace App\Containers\AppSection\Notification\Enums;

use BenSampo\Enum\Enum;

final class MailContext extends Enum
{
    public const ADMIN_UPLOADS_CONTRACT = 'admin-uploads-contract';
    public const BORROWER_ACCEPTS_TERM_SHEET = 'borrower-accepts-term-sheet';
    public const BORROWER_REJECTS_TERM_SHEET = 'borrower-rejects-term-sheet';
    public const BORROWER_SIGNED_CONTRACT = 'borrower-signed-contract';
    public const BORROWER_SUBMITS_DEAL = 'borrower-submits-deal';
    public const CHANGED_USER_PROFILE = 'changed-user-profile';
    public const DEAL_ACCEPTED = 'deal-accepted';
    public const DEAL_DOCUMENTS_REJECTED = 'deal-documents-rejected';
    public const DEAL_IS_NOT_COMPLETED_FIRST_REMINDER = 'deal-is-not-completed-first-reminder';
    public const DEAL_IS_NOT_COMPLETED_SECOND_REMINDER = 'deal-is-not-completed-second-reminder';
    public const DEAL_STATUS_CHANGED_TO_STARTED = 'deal-status-changed-to-started';
    public const LENDER_SIGNED_CONTRACT = 'lender-signed-contract';
    public const LENDER_UPLOADS_TERM_SHEET = 'lender-uploads-term-sheet';
    public const ONBOARDING_IS_NOT_FINISHED_FIRST_REMINDER = 'onboarding-is-not-finished-first-reminder';
    public const ONBOARDING_IS_NOT_FINISHED_SECOND_REMINDER = 'onboarding-is-not-finished-second-reminder';
    public const BORROWER_ONBOARDING_VERIFICATION = 'onboarding_verification';
    public const ADMIN_ONBOARDING_VERIFICATION = 'admin_onboarding_verification';
    public const PROFILE_WAS_DECLINED = 'profile_was_declined';
    public const PROFILE_WAS_APPROVED = 'profile_was_approved';
    public const PAYMENT_DATE_INSTALLMENT_REMINDER = 'payment-date-installment-reminder';
    public const UPLOAD_FINANCIALS = 'upload-financials';
    public const RECEIVE_MESSAGE = 'receive-message';
    public const PAYMENT_FIRST_REMINDER = 'payment-first-reminder';
    public const PAYMENT_SECOND_REMINDER = 'payment-second-reminder';
    public const PAYMENT_CONFIRMATION = 'payment-confirmation';
    public const PAYMENT_OVERDUE_REMINDER = 'payment-overdue-reminder';
    public const ADMIN_APPROVED_FINANCIAL_DOCUMENTS = 'admin-approved-financial-documents';
    public const ADMIN_REJECTED_FINANCIAL_DOCUMENTS = 'admin-rejected-financial-documents';
}
