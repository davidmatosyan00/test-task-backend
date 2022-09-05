<?php

namespace App\Exceptions\PaymentWebhook;

use App\Exceptions\BusinessLogicException;

class PaymentWebhookNotSaveException extends BusinessLogicException
{
    public function getStatus(): int
    {
        return BusinessLogicException::PAYMENT_WEBHOOK_NOT_SAVED;
    }

    public function getStatusMessage(): string
    {
        return __('errors.payment_webhook.not_saved');
    }
}
