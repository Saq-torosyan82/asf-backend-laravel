<?php

namespace App\Containers\AppSection\Deal\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;

class MapRequestToDealTask extends Task
{
    use HashIdTrait;

    public function run(array $data, $isUpdatable = false)
    {
        app(DecodeRequestValuesTask::class)->run($data, 'sponsorOrBrand', ['id']);
        app(DecodeRequestValuesTask::class)->run($data, 'tvHolder', ['id']);
        app(DecodeRequestValuesTask::class)->run($data, 'club', ['id', 'country_id', 'league_id', 'sport_id'], false);
        app(DecodeRequestValuesTask::class)->run($data, 'league', ['id', 'sport_id'], false);

        $deal = [
            'deal_type' => $data['deal_type'],
            'contract_type' => $data['contract_type'],
            'currency' => $data['currency'],
            'contract_amount' => $data['total'],
            'upfront_amount' => $this->cleanAmountValue($data['upfrontValue']),
            'contract_data' => $this->setContractData($data),
            'criteria_data' => [
                'tvHolder' => $data['tvHolder'],
                'sponsorsOrBrandsIdentifier' => $data['sponsorsOrBrandsIdentifier'],
                'sponsorOrBrand' => $data['sponsorOrBrand'],
                'league' => $data['league'],
                'club' => $data['club'],
                'contract_type' => $data['contract_type'],
                'user_type' => $data['user_type'],
                'athlete' => $data['athlete'],
                'club_type' => $data['club_type'],

            ],
            'first_installment' => new Carbon($data['firstInstalment']),
            'frequency' => $data['frequency'],
            'nb_installmetnts' => $data['numberOfInstalments'],
            'funding_date' => new Carbon($data['fundingDate']),
            'fees_data' => [
                'legalCost' => $data['legalCost'],
                'insuranceExpense' => $data['insuranceExpense'],
                'costs' => $data['costs']
            ],
            'payments_data' => $data['paymentEntries'],
            'interest_rate' => $data['interestRate'],
            'gross_amount' => $data['grossTotal'],
            'deal_amount' => $data['totalOfDeal'],
            'consent_data' => [
                'informedIntention' => '',
                'confirmUsageOfDocuments' => '',
                'shownToFinancier' => '',
                'confirmNoExclusivity' => '',
                'sellerAgreement' => ''
            ],
            'user_documents' => '',
            'contact_data' => '',
            'extra_data' => '',
        ];

        if ($isUpdatable) {
            $replace_data = [
                'consent_data' => [
                    'informedIntention' => $data['informedIntention'],
                    'confirmUsageOfDocuments' => $data['confirmUsageOfDocuments'],
                    'shownToFinancier' => $data['shownToFinancier'],
                    'confirmNoExclusivity' => $data['shownToFinancier'],
                    'sellerAgreement' => $data['sellerAgreement']
                ],
                'contact_data' => $data['contacts'],
                'extra_data' => [
                    'financiers' => $data['financiers']
                ]
            ];

            return array_replace($deal, $replace_data);
        }

        return $deal;
    }

    private function cleanAmountValue($amount)
    {
        return str_replace(',', '', $amount);
    }

    private function setContractData($data)
    {
        $map = [
            'contract_value' => [
                'field' => 'contractValue',
                'should_clean' => true,
            ],
            'performance_amount' => [
                'field' => 'performanceRelatedContractAmount',
                'should_clean' => true,
            ],
            'net_amount' => [
                'field' => 'netLoanAmount',
                'should_clean' => true,
            ],
            'guaranteed_amount' => [
                'field' => 'guaranteedContractAmount',
                'should_clean' => true,
            ],
            'guaranteed_contract' => [
                'field' => 'contractFullyGuaranteed',
                'should_clean' => true,
            ],
            'borrowed_amount' => [
                'field' => 'borrowedAmount',
                'should_clean' => true,
            ],
            'has_borrowed' => [
                'field' => 'borrowed',
                'should_clean' => false,
            ],
            'contract_date' => [
                'field' => 'contractDate',
                'should_clean' => false,
            ],
        ];

        $contactData = [];
        foreach ($map as $key => $config) {
            if (!isset($data[$config['field']]))
                continue;

            $value = $data[$config['field']];
            if ($config['should_clean']) {
                $value = $this->cleanAmountValue($value);
            }

            $contactData[$key] = $value;
        }

        return $contactData;
    }
}
