<?php

namespace App\Containers\AppSection\Payment\Tasks;

use App\Containers\AppSection\Payment\Data\Repositories\PaymentRepository;
use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;

class GetOverduesPaymentsTask extends Task
{
    protected PaymentRepository $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function run()
    {
        return $this->paymentRepository->where('is_paid', 0)
            ->whereDate('date', '<', Carbon::now()->format('Y-m-d'))->get();
    }
}
