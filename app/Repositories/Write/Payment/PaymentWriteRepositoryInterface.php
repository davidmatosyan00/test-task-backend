<?php

namespace App\Repositories\Write\Payment;

use App\Models\Payment;

interface PaymentWriteRepositoryInterface
{
   public function save(Payment $payment): Payment;
}
