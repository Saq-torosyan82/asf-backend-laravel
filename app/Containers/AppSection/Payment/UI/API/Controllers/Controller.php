<?php

namespace App\Containers\AppSection\Payment\UI\API\Controllers;

use App\Containers\AppSection\Payment\Actions\ConfirmPaymentAction;
use App\Containers\AppSection\Payment\Actions\GetDealsPaymentsAction;
use App\Containers\AppSection\Payment\UI\API\Requests\ConfirmPaymentRequest;
use App\Containers\AppSection\Payment\UI\API\Requests\CreatePaymentRequest;
use App\Containers\AppSection\Payment\UI\API\Requests\DeletePaymentRequest;
use App\Containers\AppSection\Payment\UI\API\Requests\GetAllPaymentsRequest;
use App\Containers\AppSection\Payment\UI\API\Requests\FindPaymentByIdRequest;
use App\Containers\AppSection\Payment\UI\API\Requests\GetDealsPaymentsRequest;
use App\Containers\AppSection\Payment\UI\API\Requests\UpdatePaymentRequest;
use App\Containers\AppSection\Payment\UI\API\Requests\PayPaymentRequest;
use App\Containers\AppSection\Payment\UI\API\Transformers\PaymentTransformer;
use App\Containers\AppSection\Payment\Actions\CreatePaymentAction;
use App\Containers\AppSection\Payment\Actions\FindPaymentByIdAction;
use App\Containers\AppSection\Payment\Actions\GetAllPaymentsAction;
use App\Containers\AppSection\Payment\Actions\UpdatePaymentAction;
use App\Containers\AppSection\Payment\Actions\DeletePaymentAction;
use App\Containers\AppSection\Payment\Actions\PayPaymentAction;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use App\Containers\AppSection\Authentication\UI\API\Requests\ValidateLoginTokenRequest;

class Controller extends ApiController
{

    public function confirmPayment(ConfirmPaymentRequest $request): JsonResponse
    {
       return app(ConfirmPaymentAction::class)->run($request);
    }

    public function createPayment(CreatePaymentRequest $request): JsonResponse
    {
        $payment = app(CreatePaymentAction::class)->run($request);
        return $this->created($this->transform($payment, PaymentTransformer::class));
    }

    public function findPaymentById(FindPaymentByIdRequest $request): array
    {
        $payment = app(FindPaymentByIdAction::class)->run($request);
        return $this->transform($payment, PaymentTransformer::class);
    }

    public function getAllPayments(GetAllPaymentsRequest $request): array
    {
        $payments = app(GetAllPaymentsAction::class)->run($request);
        return $this->transform($payments, PaymentTransformer::class);
    }

    public function getDealsPayments(GetDealsPaymentsRequest $request): JsonResponse
    {
        $payments = app(GetDealsPaymentsAction::class)->run($request);
        return new JsonResponse($payments);
    }

    public function updatePayment(UpdatePaymentRequest $request): array
    {
        $payment = app(UpdatePaymentAction::class)->run($request);
        return $this->transform($payment, PaymentTransformer::class);
    }

    public function deletePayment(DeletePaymentRequest $request): JsonResponse
    {
        app(DeletePaymentAction::class)->run($request);
        return $this->noContent();
    }

    public function payPayment(PayPaymentRequest $request): JsonResponse
    {
        app(PayPaymentAction::class)->run($request);
        return $this->noContent();
    }
}
