<?php

namespace App\Exceptions\Payment;

use App\Exceptions\BusinessLogicException;

class PaymentNotSaveException extends BusinessLogicException
{
    public function getStatus(): int
    {
        return BusinessLogicException::PAYMENT_NOT_SAVED;
    }

    public function getStatusMessage(): string
    {
        return __('errors.payment.not_saved');
    }
}
