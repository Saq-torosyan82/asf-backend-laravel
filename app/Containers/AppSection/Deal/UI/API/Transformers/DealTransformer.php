<?php

namespace App\Containers\AppSection\Deal\UI\API\Transformers;

use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Containers\AppSection\Deal\Tasks\GetCounterpartyLogoTask;
use App\Containers\AppSection\Deal\Tasks\GetCounterpartyNameTask;
use App\Containers\AppSection\Deal\Tasks\GetDealProgressPercentageTask;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileFieldTask;
use App\Containers\AppSection\UserProfile\Tasks\GetBorrowerTypeTask;
use App\Ship\Parents\Transformers\Transformer;
use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\Deal\Enums\ContractType;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\System\Enums\BorrowerType;
use Illuminate\Support\Facades\Auth;

class DealTransformer extends Transformer
{
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
        $finishDate = '';
        $paymentsData = $deal->payments_data;

        $paidBack = 0;
        foreach ($paymentsData as $paymentData) {
            if (isset($paymentData['is_paid']) && $paymentData['is_paid'] && isset($paymentData['grossAmount'])) {
                $paidBack += intval($paymentData['grossAmount']);
            }
        }
        $finishDate = $paymentData['paymentDate'];
        // temporary hack
        $tmp = explode('T', $paymentData['paymentDate']);
        if (count($tmp) == 2) {
            $finishDate = $tmp[0];
        } else {
            $finishDate = $paymentData['paymentDate'];
        }

        $response = [
            'id' => $deal->getHashedKey(),
            'type' => $deal->contract_type,
            'type_label' => ContractType::getDescription($deal->contract_type),
            'status' => $deal->status,
            'status_label' => DealStatus::getDescription($deal->status),
            'reason' => $deal->reason,
            'reason_label' => StatusReason::getDescription($deal->reason),
            'start_date' => $deal->funding_date,
            'finish_date' => $finishDate,
            'currency' => $deal->currency,
            'contract_amount' => $deal->contract_amount,
            'net_amount' => isset($deal->contract_data['net_amount']) ? (int)$deal->contract_data['net_amount'] : 0,
            'paid_back' => $paidBack,
            "status_bar" => [
                "percentaje" => app(GetDealProgressPercentageTask::class)->run($deal),
                "label" => StatusReason::getDescription($deal->reason)
            ],
            'counterparty' => [
                'name' => app(GetCounterpartyNameTask::class)->run($deal),
                'avatar' => app(GetCounterpartyLogoTask::class)->run($deal),
            ],
            "lender" => [
                "name" => '',
            ]
        ];

        $user = Auth::user();
        $borrowerType = null;

        if (!$user->roles->where('name', PermissionType::ADMIN)->first()) {
            $borrowerType = app(GetBorrowerTypeTask::class)->run($user->id);
        }

        if ($user->roles->where('name', PermissionType::ADMIN)->first()
            || ($borrowerType == BorrowerType::AGENT)) {
            $avatar = app(FindUserProfileFieldTask::class)->run($user->id, Group::USER, Key::AVATAR);
            $response['borrower'] = [
                'name' => $user->first_name . ' ' . $user->last_name,
                'avatar' => $avatar != null ? $avatar->value : ''
            ];
        }

        return $response = $this->ifAdmin(
            [
                'real_id' => $deal->id,
                // 'deleted_at' => $deal->deleted_at,
            ],
            $response
        );
    }
}
