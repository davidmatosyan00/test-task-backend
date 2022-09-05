<?php

namespace App\Services\Payment\Actions;

use App\Exceptions\Payment\PaymentNotSaveException;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\Payment\PaymentResource;
use App\Jobs\Payment\SendGateWayOnePaymentWebHookJob;
use App\Jobs\Payment\SendGateWayTwoPaymentWebHookJob;
use App\Models\Payment;
use App\Repositories\Write\Payment\PaymentWriteRepositoryInterface;
use Services\Payment\Dto\CreatePaymentDto;

class CreatePaymentAction
{
   private PaymentWriteRepositoryInterface $paymentWriteRepository;

   public function __construct(PaymentWriteRepositoryInterface $paymentWriteRepository)
   {
       $this->paymentWriteRepository = $paymentWriteRepository;
   }

   public function run(CreatePaymentDto $dto): PaymentResource | ErrorResource
   {
       try {
           $dto->status = Payment::STATUS_PENDING;

           $payment = Payment::createStatic($dto);

           $this->paymentWriteRepository->save($payment);

       } catch (PaymentNotSaveException $e) {
           return new ErrorResource(['message' => $e->getMessage(), 'code' => $e->getStatus()]);
       }

       if ($dto->method === Payment::GATE_WAY_ONE) {
           SendGateWayOnePaymentWebHookJob::dispatch($payment);
       } else {
           SendGateWayTwoPaymentWebHookJob::dispatch($payment);
       }

       return new PaymentResource($payment);
   }
}
