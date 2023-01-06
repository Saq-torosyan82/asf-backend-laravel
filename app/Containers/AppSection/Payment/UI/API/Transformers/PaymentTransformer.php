<?php

namespace App\Containers\AppSection\Payment\UI\API\Transformers;

use App\Containers\AppSection\Payment\Models\Payment;
use App\Ship\Parents\Transformers\Transformer;

class PaymentTransformer extends Transformer
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

    public function transform(Payment $payment): array
    {
        $response = [
            'object' => $payment->getResourceKey(),
            'id' => $payment->getHashedKey(),
            'user_id' => $payment->user_id,
            'email' => $payment->User->email,
            'deal_id' => $payment->deal_id,
            'deal' => $payment->Deal->deal_type,
            'amount' => $payment->amount,
            'date' => $payment->date,
            'is_paid' => $payment->is_paid,
            'paid_date' => $payment->paid_date,
            'extra_data' => $payment->extra_data
        ];

        return $response = $this->ifAdmin([
            'real_id'    => $payment->id,
            // 'deleted_at' => $payment->deleted_at,
        ], $response);
    }
}
