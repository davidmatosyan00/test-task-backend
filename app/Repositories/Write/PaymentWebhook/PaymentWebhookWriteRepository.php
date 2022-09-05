<?php

namespace App\Repositories\Write\PaymentWebhook;

use App\Exceptions\PaymentWebhook\PaymentWebhookNotSaveException;
use App\Models\PaymentWebhook;

class PaymentWebhookWriteRepository implements PaymentWebhookWriteRepositoryInterface
{
    /**
     * @throws PaymentWebhookNotSaveException
     */
    public function save(PaymentWebhook $paymentWebhook): PaymentWebhook
    {
        if (!$paymentWebhook->save()) {
            throw new PaymentWebhookNotSaveException();
        }

        return $paymentWebhook;
    }
}
