<?php

namespace App\Services\Payment\Actions;

use App\Models\Payment;
use App\Repositories\Read\Payment\PaymentReadRepository;
use App\Repositories\Read\Payment\PaymentReadRepositoryInterface;
use App\Services\Payment\Dto\CreatePaymentWebhookDto;
use App\Services\Payment\UseCases\CreatePaymentWebhookUseCase;
use App\Services\Payment\UseCases\SetConfirmedPaymentUseCase;
use Illuminate\Http\JsonResponse;

class PaymentWebhookHandleAction
{
    private PaymentReadRepositoryInterface $paymentReadRepository;
    private SetConfirmedPaymentUseCase $setConfirmedPaymentUseCase;
    private CreatePaymentWebhookUseCase $createPaymentWebhookUseCase;

    public function __construct(
        PaymentReadRepositoryInterface $paymentReadRepository,
        SetConfirmedPaymentUseCase $setConfirmedPaymentUseCase,
        CreatePaymentWebhookUseCase $createPaymentWebhookUseCase,
    ) {
        $this->paymentReadRepository = $paymentReadRepository;
        $this->setConfirmedPaymentUseCase = $setConfirmedPaymentUseCase;
        $this->createPaymentWebhookUseCase = $createPaymentWebhookUseCase;
    }

    public function run(array $data): JsonResponse
    {
        $payment = $this->paymentReadRepository->getPaymentBySign($data['sign']);

        if ($payment && $data['status'] === Payment::STATUS_COMPLETED) {
            $this->setConfirmedPaymentUseCase->run($payment);
        }

        $dto = CreatePaymentWebhookDto::fromArray([
            'paymentId' => $payment->id,
            'response' => json_encode($data),
        ]);

        $this->createPaymentWebhookUseCase->run($dto);

        return response()->json([]);
    }
}
