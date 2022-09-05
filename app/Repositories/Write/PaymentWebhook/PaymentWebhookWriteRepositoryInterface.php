<?php

namespace App\Repositories\Write\PaymentWebhook;

use App\Models\PaymentWebhook;

interface PaymentWebhookWriteRepositoryInterface
{
   public function save(PaymentWebhook $paymentWebhook): PaymentWebhook;
}
