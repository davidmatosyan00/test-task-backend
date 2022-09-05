<?php

namespace App\Services\Payment\UseCases;

use App\Models\PaymentWebhook;
use App\Repositories\Write\PaymentWebhook\PaymentWebhookWriteRepositoryInterface;
use App\Services\Payment\Dto\CreatePaymentWebhookDto;

class CreatePaymentWebhookUseCase
{
    private PaymentWebhookWriteRepositoryInterface $paymentWebhookWriteRepository;

    public function __construct(
        PaymentWebhookWriteRepositoryInterface $paymentWebhookWriteRepository
    ) {
        $this->paymentWebhookWriteRepository = $paymentWebhookWriteRepository;
    }

    public function run(CreatePaymentWebhookDto $dto): void
    {
       $paymentWebhook = PaymentWebhook::createStatic($dto);

       $this->paymentWebhookWriteRepository->save($paymentWebhook);
    }
}
