<?php

namespace App\Repositories\Write\Payment;

use App\Exceptions\Payment\PaymentNotSaveException;
use App\Models\Payment;

class PaymentWriteRepository implements PaymentWriteRepositoryInterface
{
    /**
     * @throws PaymentNotSaveException
     */
    public function save(Payment $payment): Payment
    {
        if (!$payment->save()) {
            throw new PAymentNotSaveException();
        }

        return $payment;
    }
}
