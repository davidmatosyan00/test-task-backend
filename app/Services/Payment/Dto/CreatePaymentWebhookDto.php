<?php

namespace App\Services\Payment\Dto;

class CreatePaymentWebhookDto
{
    public string $paymentId;

    public string $response;

    public static function fromArray(array $data): self
    {
       $dto = new static();

       $dto->paymentId = $data['paymentId'];
       $dto->response = $data['response'];

       return  $dto;
    }
}
