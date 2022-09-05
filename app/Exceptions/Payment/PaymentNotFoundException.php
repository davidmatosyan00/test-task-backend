<?php

namespace App\Exceptions\Payment;

use App\Exceptions\BusinessLogicException;

class PaymentNotFoundException extends BusinessLogicException
{
    public function getStatus(): int
    {
        return BusinessLogicException::PAYMENT_NOT_FOUND;
    }

    public function getStatusMessage(): string
    {
        return __('errors.payment.not_found');
    }
}
