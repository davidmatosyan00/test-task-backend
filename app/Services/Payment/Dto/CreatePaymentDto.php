<?php

namespace Services\Payment\Dto;

use App\Http\Requests\Payment\CreatePaymentRequest;

class CreatePaymentDto
{
   public string $amount;

   public string $amountPaid;

   public string $cardNumber;

   public string $method;

   public ?int $userId;

   public ?int $cardLastFourDigit;

   public ?string $status;

   public ?string $sign;

   public static function fromRequest(CreatePaymentRequest $request): self
   {
       $dto = new self();

       $dto->amount = $request->getAmount();
       $dto->amountPaid = $request->getAmountPaid();
       $dto->cardNumber = $request->getCardNumber();
       $dto->method = $request->getMethod();

       $dto->cardLastFourDigit = substr($dto->cardNumber, -4);
       $dto->userId = request()->user()->id;

       return  $dto;
   }
}
