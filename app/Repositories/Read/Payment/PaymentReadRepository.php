<?php

namespace App\Repositories\Read\Payment;

use App\Exceptions\Payment\PaymentNotFoundException;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class PaymentReadRepository implements PaymentReadRepositoryInterface
{
    private function query(): Builder
    {
        return Payment::query();
    }

    /**
     * @throws PaymentNotFoundException
     */
    public function getPaymentById(int $paymentId): Payment
    {
        $payment = $this->query()
            ->find($paymentId);

        if (!$payment) {
            throw new PaymentNotFoundException();
        }

        return $payment;
    }

    /**
     * @throws PaymentNotFoundException
     */
    public function getPaymentBySign(string $sign): Payment
    {
        $payment = $this->query()
            ->where('sign', '=', $sign)
            ->first();

        if (!$payment) {
            throw new PaymentNotFoundException();
        }

        return $payment;
    }
}
