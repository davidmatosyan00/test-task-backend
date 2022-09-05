<?php

namespace App\Repositories\Read\Payment;

use App\Models\Payment;

interface PaymentReadRepositoryInterface
{
    public function getPaymentById(int $paymentId): Payment;

    public function getPaymentBySign(string $sign): Payment;
}
