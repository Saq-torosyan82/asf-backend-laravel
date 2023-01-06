<?php

namespace App\Containers\AppSection\Deal\UI\API\Transformers;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Deal\Enums\ContractType;
use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\DealType;
use App\Containers\AppSection\Deal\Enums\OfferStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\Deal\Tasks\EncodeRequestValuesTask;
use App\Containers\AppSection\Deal\Tasks\FindLenderDealOfferTask;
use App\Containers\AppSection\Deal\Tasks\GetCounterpartyLogoTask;
use App\Containers\AppSection\Deal\Tasks\GetCounterpartyNameTask;
use App\Containers\AppSection\Deal\Tasks\GetDealProgressPercentageTask;
use App\Containers\AppSection\Deal\Tasks\GetDealsUserDocumentsTask;
use App\Containers\AppSection\Deal\Tasks\GetNextPaymentTask;
use App\Containers\AppSection\System\Tasks\GetLenderCriteriaForDealTask;
use App\Containers\AppSection\Upload\Tasks\GetUserAvatarUrlTask;
use App\Ship\Parents\Transformers\Transformer;

class DetailDealTransformer extends Transformer
{
    use HashIdTrait;

    /**
     * @var  array
     */
    protected $defaultIncludes = [

    ];

    /**
     * @var  array
     */
    protected $availableIncludes = [

    ];

    public function transform(Deal $deal): array
    {
        // get lender info
        $lender_name = '';
        $lender_avatar = '';
        // seemek should I check the deal status
        foreach ($deal->offers as $offer) {
            if ($offer->status == OfferStatus::ACCEPTED) {
                $lender_name = $offer->user->first_name . ' ' . $offer->user->last_name;
                $lender_avatar = app(GetUserAvatarUrlTask::class)->run($offer->offer_by);
            }
        }

        $response = [
            'id' => $deal->getHashedKey(),
            'user_id' => $deal->user_id,
            'deal_type' => $deal->deal_type,
            'contract_type' => $deal->contract_type,
            'status' => $deal->status,
            'status_label' => DealStatus::getDescription($deal->status),
            'reason' => $deal->reason,
            'reason_label' => StatusReason::getDescription($deal->reason),
            'currency' => $deal->currency,
            'contract_amount' => $deal->contract_amount,
            'upfront_amount' => $deal->upfront_amount,
            'interest_rate' => $deal->interest_rate,
            'gross_amount' => $deal->gross_amount,
            'deal_amount' => $deal->deal_amount,
            'first_installment' => $deal->first_installment,
            'frequency' => $deal->frequency,
            'nb_installmetnts' => $deal->nb_installmetnts,
            'funding_date' => $deal->funding_date,
            'criteria_data' => $this->processCriteriaData($deal->criteria_data),
            'payments_data' => $deal->payments_data,
            'fees_data' => $deal->fees_data,
            'user_documents' => app(GetDealsUserDocumentsTask::class)->run($deal),
            'consent_data' => $deal->consent_data,
            'contact_data' => $deal->contact_data,
            'contract_data' => $deal->contract_data,
            //'extra_data' => $deal->extra_data,
            'status_bar' => [
                "percentaje" => app(GetDealProgressPercentageTask::class)->run($deal),
                "label" => StatusReason::getDescription($deal->reason)
            ],
            'type_label' => ContractType::getDescription($deal->contract_type),
            'borrower' => [
                'name' => $deal->user->first_name . ' ' . $deal->user->last_name,
                'avatar' => app(GetUserAvatarUrlTask::class)->run($deal->user_id),
            ],
            'counterparty' => [
                'name' => app(GetCounterpartyNameTask::class)->run($deal),
                'avatar' => app(GetCounterpartyLogoTask::class)->run($deal),
            ],
            'lender' => [
                'name' => $lender_name,
                'avatar' => $lender_avatar,
            ],
            'paid_back' => 0, // SEEMEk: change here !!
            'next_payment' => app(GetNextPaymentTask::class)->run($deal),
        ];

        // add quote type
        if($deal->deal_type == DealType::FUTURE) {
            $response['quote_type'] = $deal->submited_data['quoteType'];
        }

        // add contract information
        if (isset($deal->extra_data['contract'])) {
            $current = $deal->extra_data['contract']['current'];
            $response['contract'] = [
                'current' => [
                    'id' => $this->encode($current['id']),
                    'date' => $current['date'],
                    'url' => downloadUrl($current['uuid']),
                ],
                'history' => [],
            ];
            if (isset($deal->extra_data['contract']['history'])) {
                foreach ($deal->extra_data['contract']['history'] as $row) {
                    $response['contract']['history'][] = [
                        'id' => $this->encode($row['id']),
                        'date' => $row['date'],
                        'url' => downloadUrl($row['uuid']),
                    ];
                }
            }
        }

        $user = \Auth::user();
        if ($user->isLender()) {
            $response['offer'] = [];
            $offer = app(FindLenderDealOfferTask::class)->run($deal->id, $user->id);
            if (!is_null($offer)) {
                $response['offer'] = [
                    'status' => $offer->status,
                    'reject_reason' => $offer->reject_reason,
                    'term_sheet' => downloadUrl($offer->termsheet->uuid)
                ];
            }
        };

        if ($user->isBorrower()) {
            if ($deal->status == DealStatus::LIVE && $deal->reason == StatusReason::APPROVED_ASF) {
                $lenders = app(GetLenderCriteriaForDealTask::class)->run($deal);
                if ($lenders) {
                    $response['lender_criterias'] = $lenders['lender_names'];
                }
            }
        }

        if ($user->isBorrower() || $user->isAdmin()) {
            $response['offers'] = [];
            // add offers

            foreach ($deal->offers as $offer) {
                $response['offers'][] = [
                    'id' => $this->encode($offer->id),
                    'lender' => $offer->user->first_name . ' ' . $offer->user->last_name,
                    'termsheet' => [
                        'name' => 'Termsheet',
                        'date' => $offer->created_at->format('d.m.Y'),
                        'link' => downloadUrl($offer->termsheet->uuid),
                        'status' => $offer->status
                    ]
                ];
            }
        }

        if ($user->isAdmin() || $user->isLender()) {
            if (isset($deal->extra_data['credit_analysis'])) {
                $ca = $deal->extra_data['credit_analysis'];
                // SEEMEk: type and label shouldn't be hardcoded
                $response['user_documents'][] = [
                    'type' => 'credit_analysis',
                    'label' => 'Credit Analysis',
                    'is_multiple' => false,
                    'id' => $this->encode($ca['id']),
                    'url' => downloadUrl($ca['uuid']),
                    'is_verified' => 1,
                    'upload_date' => $ca['date']
                ];
            }
        }

        return $response;
    }

    private function processCriteriaData($data)
    {
        app(EncodeRequestValuesTask::class)->run($data, 'sponsorOrBrand', ['id']);
        app(EncodeRequestValuesTask::class)->run($data, 'tvHolder', ['id']);
        app(EncodeRequestValuesTask::class)->run($data, 'club', ['id', 'country_id', 'league_id', 'sport_id'], false);
        app(EncodeRequestValuesTask::class)->run($data, 'league', ['id', 'sport_id'], false);

        return $data;
    }
}
