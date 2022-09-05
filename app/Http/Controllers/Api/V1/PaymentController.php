<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\CreatePaymentRequest;
use App\Http\Requests\Payment\PaymentWebhookRequest;
use App\Services\Payment\Actions\CreatePaymentAction;
use App\Services\Payment\Actions\PaymentWebhookHandleAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Services\Payment\Dto\CreatePaymentDto;

class PaymentController extends Controller
{
    private CreatePaymentAction $createPaymentAction;

    private PaymentWebhookHandleAction $paymentWebhookHandleAction;

    public function __construct(
        CreatePaymentAction $createPaymentAction,
        PaymentWebhookHandleAction $paymentWebhookHandleAction,
    ) {
        $this->createPaymentAction = $createPaymentAction;
        $this->paymentWebhookHandleAction = $paymentWebhookHandleAction;
    }

    public function payment(CreatePaymentRequest $request): JsonResource
    {
        $dto = CreatePaymentDto::fromRequest($request);

        return $this->createPaymentAction->run($dto);
    }

    public function webhook(PaymentWebhookRequest $request): JsonResponse
    {
        $data = $request->toArray();

        $sign = $request->header('Authorization');

        if ($sign) {
            $data['sign'] = $sign;
        }

        return $this->paymentWebhookHandleAction->run($data);
    }
}
