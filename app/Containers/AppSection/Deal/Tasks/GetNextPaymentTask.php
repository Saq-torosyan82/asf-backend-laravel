<?php

namespace App\Containers\AppSection\Deal\Tasks;

use App\Containers\AppSection\Payment\Enums\PaymentStatus;
use App\Containers\AppSection\Payment\Tasks\GetPaymentsByDealIdTask;
use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;

class GetNextPaymentTask extends Task
{
    public function run($deal)
    {
        if (!$deal->isContractSigned()) {
            if (!isset($deal->payments_data) || !is_array($deal->payments_data) || !count($deal->payments_data)) {
                // this shouldn't happen
                return [
                    'status' => '', // hardcoded for the moment
                    'amount' => 0,
                    'payment_date' => '0000-00-00',
                    'crt_installment' => 0,
                    'nb_installments' => 0,
                ];
            }

            return [
                'status' => PaymentStatus::getDescription(PaymentStatus::PENDING),
                'amount' => $deal->payments_data[0]['grossAmount'],
                'payment_date' => substr($deal->payments_data[0]['paymentDate'], 0, 10),
                'crt_installment' => 1,
                'nb_installments' => count($deal->payments_data),
            ];
        }

        // get all payments
        $payments = app(GetPaymentsByDealIdTask::class)->run($deal->id);
        $now = Carbon::now()->format('Y-m-d');
        $crt_installment = 0;
        $prev_payment = null;
        foreach ($payments as $payment) {
            if ($payment->date >= $now) {
                break;
            }

            $crt_installment++;
            $prev_payment = $payment;
        }

        if (is_null($prev_payment) || $prev_payment->is_paid) {
            $amount = $payment->amount;
            $payment_date = $payment->date->format('d.m.Y');
            $status = PaymentStatus::getDescription($payment->is_paid ? PaymentStatus::PAID : PaymentStatus::PENDING);
            $crt_installment++;
        } else {
            $amount = $prev_payment->amount;
            $payment_date = $prev_payment->date->format('d.m.Y');
            $status = PaymentStatus::getDescription(PaymentStatus::DELAYED);
        }

        return [
            'status' => $status,
            'amount' => $amount,
            'payment_date' => $payment_date,
            'crt_installment' => $crt_installment,
            'nb_installments' => count($payments),
        ];
    }
}
