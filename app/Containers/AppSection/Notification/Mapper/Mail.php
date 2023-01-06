<?php

namespace App\Containers\AppSection\Notification\Mapper;

use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Enums\MailReceiver;
use App\Containers\AppSection\User\Models\User;

class Mail
{
    public static $MAIL = [
        MailContext::PROFILE_WAS_APPROVED => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "You are verified",
                ]
            ],
            'entity' => User::class,
        ],
        MailContext::PROFILE_WAS_DECLINED => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "Your profile was declined",
                ]
            ],
            'entity' => User::class,
        ],
        MailContext::ADMIN_ONBOARDING_VERIFICATION => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "User needs verification",
                ]
            ],
            'entity' => User::class,
        ],
        MailContext::BORROWER_ONBOARDING_VERIFICATION => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "You need verification",
                ]
            ],
            'entity' => User::class,
        ],
        MailContext::ONBOARDING_IS_NOT_FINISHED_FIRST_REMINDER => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "Borrower Sign up for SportsFi account, but didn't finish Onboarding(borrower)",
                ],
                MailReceiver::ADMIN => [
                    'subject' => "Borrower Sign up for SportsFi account, but didn't finish Onboarding(admin)",
                ]
            ],
            'entity' => User::class,
        ],
        MailContext::ONBOARDING_IS_NOT_FINISHED_SECOND_REMINDER => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "Borrower Sign up for SportsFi account, but didn't finish Onboarding(borrower)",
                ],
                MailReceiver::ADMIN => [
                    'subject' => "Borrower Sign up for SportsFi account, but didn't finish Onboarding(admin)",
                ]
            ],
            'entity' => User::class,
        ],
        MailContext::DEAL_IS_NOT_COMPLETED_FIRST_REMINDER => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "Borrower starts a Deal, but didn't complete it, deal is saved for later.",
                ],
                MailReceiver::ADMIN => [
                    'subject' => "Borrower starts a Deal, but didn't complete it, deal is saved for later.",
                ]
            ],
            'entity' => Deal::class,
        ],
        MailContext::DEAL_IS_NOT_COMPLETED_SECOND_REMINDER => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "Borrower starts a Deal, but didn't complete it, deal is saved for later.",
                ],
                MailReceiver::ADMIN => [
                    'subject' => "Borrower starts a Deal, but didn't complete it, deal is saved for later.",
                ]
            ],
            'entity' => Deal::class,
        ],
        MailContext::BORROWER_SUBMITS_DEAL => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "Borrower submits the deal (all documents, forms are filled)",
                ],
                MailReceiver::ADMIN => [
                    'subject' => "Borrower submits the deal (all documents, forms are filled)",
                ]
            ],
            'entity' => Deal::class,
        ],
        MailContext::DEAL_DOCUMENTS_REJECTED => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "SportsFi admin rejects deal documents",
                ],
                MailReceiver::ADMIN => [
                    'subject' => "SportsFi admin rejects deal documents",
                ]
            ],
            'entity' => Deal::class,
        ],
        MailContext::DEAL_ACCEPTED => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "SportsFi admin accepts the deal (approve documentation)",
                ],
                MailReceiver::ADMIN => [
                    'subject' => "SportsFi admin accepts the deal (approve documentation)",
                ],
                MailReceiver::LENDER => [
                    'subject' => "SportsFi admin accepts the deal (approve documentation)",
                ]
            ],
            'entity' => Deal::class,
        ],
        MailContext::LENDER_UPLOADS_TERM_SHEET => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "Lender uploads Term sheet",
                ],
                MailReceiver::ADMIN => [
                    'subject' => "Lender uploads Term sheet",
                ],
                MailReceiver::LENDER => [
                    'subject' => "Lender uploads Term sheet",
                ]
            ],
            'entity' => Deal::class,
        ],
        MailContext::BORROWER_REJECTS_TERM_SHEET => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "Borrower rejects Term sheet or all Term sheets",
                ],
                MailReceiver::ADMIN => [
                    'subject' => "Borrower rejects Term sheet or all Term sheets",
                ],
                MailReceiver::LENDER => [
                    'subject' => "Borrower rejects Term sheet or all Term sheets",
                ]
            ],
            'entity' => Deal::class,
        ],
        MailContext::BORROWER_ACCEPTS_TERM_SHEET => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "Borrower accepts Term sheet or all Term sheets",
                ],
                MailReceiver::ADMIN => [
                    'subject' => "Borrower accepts Term sheet or all Term sheets",
                ],
                MailReceiver::LENDER => [
                    'subject' => "Borrower accepts Term sheet or all Term sheets",
                ]
            ],
            'entity' => Deal::class,
        ],
        MailContext::ADMIN_UPLOADS_CONTRACT => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "SportsFi admin uploads Contract",
                ],
                MailReceiver::LENDER => [
                    'subject' => "SportsFi admin uploads Contract",
                ]
            ],
            'entity' => Deal::class,
        ],
        MailContext::BORROWER_SIGNED_CONTRACT => [
            'receivers' => [
                MailReceiver::ADMIN => [
                    'subject' => "Borrower signed Contract",
                ],
                MailReceiver::LENDER => [
                    'subject' => "Borrower signed Contract",
                ]
            ],
            'entity' => Deal::class,
        ],
        MailContext::LENDER_SIGNED_CONTRACT => [
            'receivers' => [
                MailReceiver::ADMIN => [
                    'subject' => "Lender signed Contract",
                ],
                MailReceiver::BORROWER => [
                    'subject' => "Lender signed Contract",
                ]
            ],
            'entity' => Deal::class,
        ],
        MailContext::DEAL_STATUS_CHANGED_TO_STARTED => [
            'receivers' => [
                MailReceiver::ADMIN => [
                    'subject' => "Deal status changed to Started",
                ],
                MailReceiver::BORROWER => [
                    'subject' => "Deal status changed to Started",
                ],
                MailReceiver::LENDER => [
                    'subject' => "Deal status changed to Started",
                ]
            ],
            'entity' => Deal::class,
        ],
        MailContext::PAYMENT_DATE_INSTALLMENT_REMINDER => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "Payment date - installment reminder",
                ],
                MailReceiver::LENDER => [
                    'subject' => "Payment date - installment reminder",
                ]
            ],
            'entity' => Deal::class,
        ],
        MailContext::UPLOAD_FINANCIALS => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "Upload financials",
                ],
                MailReceiver::ADMIN => [
                    'subject' => "Upload financials",
                ]
            ],
            'entity' => User::class,
        ],
        MailContext::CHANGED_USER_PROFILE => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "Changed user profile",
                ],
                MailReceiver::ADMIN => [
                    'subject' => "Changed user profile",
                ],
                MailReceiver::PARENT => [
                    'subject' => "Changed user profile",
                ]
            ],
            'entity' => User::class,
        ],
        MailContext::RECEIVE_MESSAGE => [
            'receivers' => [
                MailReceiver::PARTICIPANT => [
                    'subject' => "Received new message",
                ]
            ],
            'entity' => User::class,
        ],
        MailContext::PAYMENT_FIRST_REMINDER => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "First reminder payment notification",
                ]
            ],
            'entity' => User::class,
        ],
        MailContext::PAYMENT_SECOND_REMINDER => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "Second reminder payment notification",
                ]
            ],
            'entity' => User::class,
        ],
        MailContext::PAYMENT_CONFIRMATION => [
            'receivers' => [
                MailReceiver::LENDER => [
                    'subject' => "Payment confirmation",
                ]
            ],
            'entity' => User::class,
        ],
        MailContext::PAYMENT_OVERDUE_REMINDER => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "Payment overdue reminder",
                ]
            ],
            'entity' => User::class,
        ],
        MailContext::ADMIN_APPROVED_FINANCIAL_DOCUMENTS => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "Financial documents approved",
                ]
            ],
            'entity' => User::class,
        ],
        MailContext::ADMIN_REJECTED_FINANCIAL_DOCUMENTS => [
            'receivers' => [
                MailReceiver::BORROWER => [
                    'subject' => "Financial documents rejected",
                ]
            ],
            'entity' => User::class,
        ],
    ];
}
