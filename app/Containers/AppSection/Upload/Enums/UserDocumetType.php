<?php

namespace App\Containers\AppSection\Upload\Enums;

use App\Containers\AppSection\Deal\Enums\ContractType;
use BenSampo\Enum\Enum;

final class UserDocumetType extends Enum
{
    const CONTRACT = 'contract';
    const SUPPORTING_INFORMATION = 'supporting_information';
    const TWO_YEARS_ACCOUNTS = 'two_years_accounts';
    const MANAGEMENT_ACCOUNTS = 'management_accounts';
    const QUARTERLY_BALANCE_SHEETS = 'quarterly_balance_sheets';
    const INCOME_STATEMENTS = 'income_statements';
    const CASH_FLOW_STATEMENTS = 'cash_flow_statements';
    // for Player Transfer
    const TRANSFER_CONTRACT = 'transfer_contract';
    // A copy of the International Transfer Certificate (ITC)
    const ITC = 'itc';

    // Club Owner/s ID (Driver License, Passport, or Visa) (PDF or JPEG Format)
    const CLUB_OWNER_ID = 'club_owner_id';
    // Proof of address
    const PROOF_OF_ADDRESS = 'proof_of_address';
    // Company Incorporation Document (LTD or LLC)
    const COMPANY_INCORPORATION = 'company_incorporation';
    // Copy of transfer agreement
    const TRANSFER_AGREEMENT = 'transfer_agreement';
    // Club Ownership Structure
    const OWNERSHIP_STRUCTURE = 'ownership_structure';
    // copy of the last two years accounts (PDF Format)

    // copy of the existing management accounts for the last 12 months (Excel Format)
    const MANAGEMENT_ACCOUNTS_TWELVE_MONTHS = 'management_accounts_twelve_months';

    // Monthly or Quarterly projections of balance sheets, income and cash flow statements (Excel Format)
    const MONTHLY_QUARTERLY_PROJECTIONS = 'monthly_quarterly_projections';

    // List of payables (Club Transfers) (Excel or PDF Format)
    const LIST_OF_PAYABLES = 'list_of_payables';

    // List of Receivables (Excel or PDF Format)
    const LIST_OF_RECEIVABLES = 'list_of_receivables';

    // Management information since the last financial year end on a monthly basis in excel (Excel Format)
    const MANAGEMENT_INFORMATION = 'management_information';

    // Any other supporting information (Excel or PDF Format)
    const OTHER_SUPORTING_INFORMATION = 'other_suporting_information';

    const ID = 'id';
    const OBLIGOR_TWO_YEARS_FINANCIAL = 'obligor_two_years_financial';
    const OBLIGOR_SUPORTING_INFORMATION = 'obligor_suporting_information';
    const AGENT_REPRESENTATION_AGREEMENT = 'agent_representation_agreement';
    const SPORTS_MARKETING_REPRESENTATION_AGREEMENT = 'sports_marketing_representation_agreement';
    const COMMISSION_AGREEMENT = 'commission_agreement';
    const AGENT_LICENSE = 'agent_license';
    const TEAM_CONTRACT = 'team_contract';

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::CONTRACT:
                return 'Contract';

            case self::SUPPORTING_INFORMATION:
                return 'Supporting Information';

            case self::TWO_YEARS_ACCOUNTS:
                return 'Copy of the last two years accounts (PDF Format)';

            case self::MANAGEMENT_ACCOUNTS:
                return 'Management accounts';

            case self::QUARTERLY_BALANCE_SHEETS:
                return 'Quarterly balance sheets';

            case self::INCOME_STATEMENTS:
                return 'Income statements';

            case self::CASH_FLOW_STATEMENTS:
                return 'Cash flow statements';

            case self::TRANSFER_CONTRACT:
                return 'Transfer Contracts and Invoices';

            case self::ITC:
                return 'ITC (International transfer certificate)';

            case self::PROOF_OF_ADDRESS:
                return 'Proof of address';

            case self::COMPANY_INCORPORATION:
                return 'Company Incorporation Document';

            case self::TRANSFER_AGREEMENT:
                return 'Copy of transfer agreement';

            case self::OWNERSHIP_STRUCTURE:
                return 'Ownership Structure';

            case self::MANAGEMENT_ACCOUNTS_TWELVE_MONTHS:
                return 'Copy of the existing management accounts for the last 12 months';

            case self::MONTHLY_QUARTERLY_PROJECTIONS:
                return 'Monthly or Quarterly projections of balance sheets, income and cash flow statements';

            case self::LIST_OF_PAYABLES:
                return 'List of payables (Club Transfers)';

            case self::LIST_OF_RECEIVABLES:
                return 'List of Receivables';

            case self::MANAGEMENT_INFORMATION:
                return 'Management information since the last FY end on a monthly basis';

            case self::OTHER_SUPORTING_INFORMATION:
                return 'Any other Supporting Information';

            case self::ID:
                return 'ID';

            case self::OBLIGOR_TWO_YEARS_FINANCIAL:
                return 'Past two years financial reports on the obligor';

            case self::OBLIGOR_SUPORTING_INFORMATION:
                return 'Supporting Information on the Obligor ownership';

            case self::AGENT_REPRESENTATION_AGREEMENT:
                return 'Agent Representation Agreement';

            case self::SPORTS_MARKETING_REPRESENTATION_AGREEMENT:
                return 'Sports Marketing Rep Contract';

            case self::COMMISSION_AGREEMENT:
                return 'Commission Agreement';

            case self::AGENT_LICENSE:
                return 'Agent License';

            case self::TEAM_CONTRACT:
                return 'Copy of Professional Team Contract';
        }

        return parent::getDescription($value);
    }

    public static function isPlayerTransferKey($key)
    {
        $map = [
            self::TRANSFER_CONTRACT => 1,
            self::ITC => 1,
        ];

        return isset($map[$key]);
    }

    public static function isMultipleDocument($key)
    {
        $map = [
            self::SUPPORTING_INFORMATION => 1,
            self::OTHER_SUPORTING_INFORMATION => 1,
        ];

        return isset($map[$key]);
    }

    public static function getRequiredDealDocuments(string $type)
    {
        $documents = self::getMap($type);
        return is_null($documents) ? [] : array_keys($documents);
    }

    private static function getMap($type)
    {
        $map = [
            ContractType::PLAYER_TRANSFER => [
                self::ID => [
                    'label' => 'Club Owner/s ID (Driver License, Passport, or Visa)'
                ],
                self::PROOF_OF_ADDRESS => [],
                self::COMPANY_INCORPORATION => [],
//                self::TRANSFER_AGREEMENT => [],
//                self::ITC => [],
                self::OWNERSHIP_STRUCTURE => [
                    'label' => 'Club Ownership Structure'
                ],
                self::TWO_YEARS_ACCOUNTS => [],
                self::MANAGEMENT_ACCOUNTS_TWELVE_MONTHS => [],
                self::MONTHLY_QUARTERLY_PROJECTIONS => [],
                self::LIST_OF_PAYABLES => [],
                self::LIST_OF_RECEIVABLES => [],
                self::MANAGEMENT_INFORMATION => [],
                self::OTHER_SUPORTING_INFORMATION => [],
            ],
            ContractType::MEDIA_RIGHTS => [
                self::ID => [
                    'label' => 'ID',
                ],
                self::PROOF_OF_ADDRESS => [],
                self::COMPANY_INCORPORATION => [],
                self::OWNERSHIP_STRUCTURE => [
                    'label' => 'Ownership Structure',
                ],
                self::CONTRACT => [
                    'label' => 'Copy of the signed contract governing the receivable'
                ],
                self::TWO_YEARS_ACCOUNTS => [
                    'label' => 'A copy of the last two years accounts'
                ],
                self::MANAGEMENT_ACCOUNTS_TWELVE_MONTHS => [
                    'label' => 'A copy of the existing management accounts (the last 12 months)',
                ],
                self::MONTHLY_QUARTERLY_PROJECTIONS => [
                    'label' => 'Monthly or Quarterly projections of BS, income and CF statements',
                ],
                self::LIST_OF_PAYABLES => [],
                self::LIST_OF_RECEIVABLES => [],
                self::MANAGEMENT_INFORMATION => [],
                self::OBLIGOR_TWO_YEARS_FINANCIAL => [],
                self::OBLIGOR_SUPORTING_INFORMATION => [],
                self::OTHER_SUPORTING_INFORMATION => [],
            ],
            ContractType::AGENT_FEES => [
                self::ID => [
                    'label' => 'ID',
                ],
                self::PROOF_OF_ADDRESS => [],
                self::COMPANY_INCORPORATION => [],
                self::OWNERSHIP_STRUCTURE => [
                    'label' => 'Agency Ownership Structure',
                ],
                self::CONTRACT => [
                    'label' => 'Copy of the signed contract governing the receivable',
                ],
                self::AGENT_REPRESENTATION_AGREEMENT => [],
                self::SPORTS_MARKETING_REPRESENTATION_AGREEMENT => [],
                self::COMMISSION_AGREEMENT => [],
                self::AGENT_LICENSE => []
            ],
            ContractType::ENDORSEMENT => [
                self::ID => [],
                self::PROOF_OF_ADDRESS => [],
                self::COMPANY_INCORPORATION => [],
                self::CONTRACT => [
                    'label' => 'Copy of the signed contract governing the receivable',
                ],
                self::AGENT_REPRESENTATION_AGREEMENT => [
                    'label' => 'Agent Representation agreement',
                ],
                self::SPORTS_MARKETING_REPRESENTATION_AGREEMENT => [
                    'label' => 'Sports Marketing Rep Contract',
                ],
                self::OTHER_SUPORTING_INFORMATION => [
                    'label' => 'Any other Supporting Information',
                ]
            ],
            ContractType::PLAYER_ADVANCE => [
                self::ID => [],
                self::PROOF_OF_ADDRESS => [
                    'label' => 'Proof of address',
                ],
                self::TEAM_CONTRACT => []
            ]
        ];

        return isset($map[$type]) ? $map[$type] : null;
    }

    public static function getDescriptionByType($value, $type)
    {
        $documents = self::getMap($type);
        if (is_null($documents) || !isset($documents[$value])) {
            return self::getDescription($value);
        }

        return isset($documents[$value]['label']) ? $documents[$value]['label'] : self::getDescription($value);
    }
}
