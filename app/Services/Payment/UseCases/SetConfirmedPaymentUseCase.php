<?php

namespace App\Services\Payment\UseCases;

use App\Models\Payment;
use App\Repositories\Read\Payment\PaymentReadRepositoryInterface;
use App\Repositories\Write\Payment\PaymentWriteRepositoryInterface;

class SetConfirmedPaymentUseCase
{
    private PaymentWriteRepositoryInterface $paymentWriteRepository;

    public function __construct(
        PaymentWriteRepositoryInterface $paymentWriteRepository,
    ) {
        $this->paymentWriteRepository = $paymentWriteRepository;
    }

    public function run(Payment $payment): void
    {
        $payment->setStatus(Payment::STATUS_COMPLETED);

        $this->paymentWriteRepository->save($payment);
    }
}
