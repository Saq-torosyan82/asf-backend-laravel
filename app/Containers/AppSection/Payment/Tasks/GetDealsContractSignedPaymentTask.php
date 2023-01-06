<?php

namespace App\Containers\AppSection\Payment\Tasks;

use App\Containers\AppSection\Deal\Data\Repositories\DealRepository;
use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Ship\Parents\Tasks\Task;

class GetDealsContractSignedPaymentTask extends Task
{
    protected DealRepository $dealRepository;

    public function __construct(DealRepository $dealRepository)
    {
        $this->dealRepository = $dealRepository;
    }

    public function run()
    {
        return $this->dealRepository->select(
            'id',
            'user_id',
            'payments_data',
        )
            ->whereNotIn('id', function($query) {
                $query->select('deal_id')->from('payments');
            })
            ->where('status', DealStatus::STARTED)
            ->where('reason', StatusReason::CONTRACT_SIGNED)
            ->get();

    }
}
