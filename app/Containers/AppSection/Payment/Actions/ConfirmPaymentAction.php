<?php

namespace App\Containers\AppSection\Payment\Actions;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Authentication\Actions\ValidateLoginTokenAction;
use App\Containers\AppSection\Deal\Tasks\UpdateDealTask;
use App\Containers\AppSection\Payment\Tasks\FindPaymentByIdTask;
use App\Containers\AppSection\Payment\Tasks\UpdatePaymentTask;
use App\Containers\AppSection\Payment\UI\API\Requests\ConfirmPaymentRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;
use App\Containers\AppSection\Authentication\UI\API\Requests\ValidateLoginTokenRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;


class ConfirmPaymentAction extends Action
{
    use HashIdTrait;

    public function run(ConfirmPaymentRequest $request): JsonResponse
    {
        try {
            $paymentId = $this->decode($request->payment);
            $payment = app(FindPaymentByIdTask::class)->run($paymentId);
            if(!$payment) throw new NotFoundException();
            if((bool)$request->confirm) {
                $data = [
                    'is_paid' => 1,
                    'paid_date' => Carbon::now()->format('Y-m-d')
                ];
                app(UpdatePaymentTask::class)->run($paymentId, $data);
            }else {
                $extraData = $payment->extra_data;
                $extraData['is_ovrerdue'] = 1;
                $paymentExtraData = [
                    'extra_data' => $extraData
                ];
                app(UpdatePaymentTask::class)->run($paymentId, $paymentExtraData);
            }

            return new JsonResponse($payment);

        }catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }


    }
}
